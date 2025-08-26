<?php

namespace App\Repositories\Eloquent;

use App\Models\Bank;
use App\Repositories\Contracts\BankRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BankRepository implements BankRepositoryInterface
{

    protected function nonAccent($str)
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

    public function prepareData(array $data)
    {
        return [
            'bank_name' => strtoupper(trim($data['bank_name'])),
            'account_name' => $this->nonAccent($data['account_name']),
            'account_number' => $data['account_number'],
            'status' => $data['status'],
            'description' => $data['description'],
        ];
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Bank::query()->latest()->paginate($perPage);
    }

    public function getById(int $id)
    {
        return Bank::findOrFail($id);
    }

    public function create(array $data)
    {
        $data = $this->prepareData($data);
        return Bank::create($data);
    }

    public function update(int $id, array $data)
    {
        $bank = $this->getById($id);
        $bank->update($this->prepareData($data));
        return $bank;
    }

    public function delete(int $id): bool
    {
        $bank = $this->getById($id);
        return (bool) $bank->delete();
    }
}
