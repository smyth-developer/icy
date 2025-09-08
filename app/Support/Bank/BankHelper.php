<?php

namespace App\Support\Bank;

use App\Models\Subject;
use Illuminate\Support\Facades\Http;
use App\Repositories\Contracts\SeasonRepositoryInterface;
use App\Repositories\Contracts\StudentRepositoryInterface;

class BankHelper
{

    public static function getBanks(): array
    {
        $response = Http::get('https://api.vietqr.io/v2/banks');
        return $response->json()['data'];
    }

    /**
     * Bỏ dấu tiếng Việt, để xử lý tên ngân hàng
     */
    public static function nonAccent($str): string
    {
        $str = mb_strtoupper($str, 'UTF-8');
        $unicode = [
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
        ];
        foreach ($unicode as $nonAccent => $accent) {
            $str = preg_replace("/($accent)/i", $nonAccent, $str);
        }
        return mb_strtoupper($str, 'UTF-8');
    }

    public static function buildVietQR(string $bankCode, string $accountNo, string $amount = '', string $desc = ''): string
    {

        $bankCode = trim($bankCode);
        $accountNo = trim($accountNo);
        $amount = trim($amount);
        $desc = trim($desc);

        // TLV helpers
        $pad2 = fn(string $s) => strlen($s) < 2 ? '0' . $s : $s;
        $tlv  = fn(string $id, string $value) => $id . $pad2((string)strlen($value)) . $value;

        // --- EMVCo / VietQR ---
        $payload  = $tlv('00', '01');                         // Version
        $payload .= $tlv('01', ($amount !== '') ? '12' : '11'); // Dynamic if amount present

        // 38 = GUID + (01: accInfo+stk) + (02: QRIBFTTA)
        $guid   = $tlv('00', 'A000000727');                   // GUID
        $accInf = $tlv('00', $bankCode);                      // bankCode
        $stk    = $tlv('01', $accountNo);                     // accountNo
        $tkWrap = $tlv('01', $accInf . $stk);                 // wrap accInfo+stk vào tag 01
        $svc    = $tlv('02', 'QRIBFTTA');                     // service code
        $payload .= $tlv('38', $guid . $tkWrap . $svc);       // Merchant Account Info

        $payload .= $tlv('53', '704');                        // Currency VND
        if ($amount !== '') {
            $payload .= $tlv('54', $amount);                  // Amount
        }
        $payload .= $tlv('58', 'VN');                         // Country

        if ($desc !== '') {
            $payload .= $tlv('62', $tlv('08', $desc));        // Additional Data (08 = description)
        }

        // CRC16-CCITT (0xFFFF)
        $payloadCRC = $payload . '6304';
        $crc = (function (string $data): string {
            $crc = 0xFFFF;
            $poly = 0x1021;
            $len = strlen($data);
            for ($i = 0; $i < $len; $i++) {
                $crc ^= (ord($data[$i]) << 8);
                for ($b = 0; $b < 8; $b++) {
                    $crc = ($crc & 0x8000) ? (($crc << 1) ^ $poly) : ($crc << 1);
                    $crc &= 0xFFFF;
                }
            }
            return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
        })($payloadCRC);

        return $payloadCRC . $crc;
    }

    public static function getBankCode(string $bankName): string
    {
        $banks = self::getBanks();
        $bank = collect($banks)->firstWhere('shortName', $bankName);
        return $bank['bin'];
    }

    public static function generateDescriptionTransaction(string $studentName, string $programName, string $seasonName): string
    {
        return "{$studentName} - {$programName} - {$seasonName}";
    }

    public static function generateDescriptionTransactionBankTransfer(int $studentId, int $seasonId, int $programId): string
    {
        $student = strtoupper(app(StudentRepositoryInterface::class)->getStudentById($studentId)->username);
        $season = app(SeasonRepositoryInterface::class)->getSeasonById($seasonId);
        $subject_code = substr(Subject::find($programId)?->code, 0, 2);
        $uniqid = uniqid();
        return "{$student}_{$season->code}_{$subject_code}_{$uniqid}";
    }

}
