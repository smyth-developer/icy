<?php

namespace Database\Seeders;

use App\Models\Tuition;
use App\Models\User;
use App\Models\Program;
use App\Models\Season;
use App\Models\Bank;
use Illuminate\Database\Seeder;

class TuitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy dữ liệu mẫu
        $users = User::whereHas('roles', function($query) {
            $query->where('roles.id', 3); // Lấy học viên (role_id = 3)
        })->get();
        $programs = Program::all();
        $seasons = Season::all();
        $banks = Bank::all();

        if ($users->isEmpty() || $programs->isEmpty() || $seasons->isEmpty()) {
            $this->command->info('Không có đủ dữ liệu để tạo tuition. Vui lòng chạy các seeder khác trước.');
            return;
        }

        // Tạo 30 bản ghi tuition mẫu
        $tuitions = [];
        $statuses = ['paid', 'pending', 'failed'];
        $paymentMethods = ['cash', 'bank_transfer'];
        $notes = [
            'Đóng học phí kỳ 1',
            'Chuyển khoản ngân hàng',
            'Chờ xác nhận',
            'Giao dịch thất bại',
            'Đóng học phí IELTS',
            'Thanh toán tiền mặt',
            'Chuyển khoản VIB',
            'Chuyển khoản MBBank',
            'Đóng học phí TOEIC',
            'Thanh toán thẻ tín dụng',
            'Đóng học phí giao tiếp',
            'Chuyển khoản Techcombank',
            'Đóng học phí doanh nghiệp',
            'Thanh toán online',
            'Đóng học phí thiếu nhi',
            'Chuyển khoản BIDV',
            'Đóng học phí thiếu niên',
            'Thanh toán qua ví điện tử',
            'Đóng học phí luyện thi',
            'Chuyển khoản Vietcombank',
            'Đóng học phí mẫu giáo',
            'Thanh toán trả góp',
            'Đóng học phí cơ bản',
            'Chuyển khoản Agribank',
            'Đóng học phí nâng cao',
            'Thanh toán qua ATM',
            'Đóng học phí chuyên sâu',
            'Chuyển khoản TPBank',
            'Đóng học phí cấp tốc',
            'Thanh toán qua POS'
        ];

        // Lấy số receipt_number cao nhất hiện tại
        $maxReceipt = Tuition::max('receipt_number');
        $startNumber = 1;
        if ($maxReceipt) {
            $startNumber = (int) str_replace('RCP', '', $maxReceipt) + 1;
        }

        for ($i = 0; $i < 30; $i++) {
            $user = $users->random();
            $program = $programs->random();
            $season = $seasons->random();
            $bank = $banks->random();
            $status = $statuses[array_rand($statuses)];
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            $note = $notes[array_rand($notes)];
            
            // Giá ngẫu nhiên từ 1.5M đến 5M
            $price = rand(1500000, 5000000);
            
            $tuitions[] = [
                'user_id' => $user->id,
                'receipt_number' => 'RCP' . str_pad($startNumber + $i, 3, '0', STR_PAD_LEFT),
                'program_id' => $program->id,
                'season_id' => $season->id,
                'price' => $price,
                'status' => $status,
                'payment_method' => $paymentMethod,
                'bank_id' => $paymentMethod === 'bank_transfer' ? $bank->id : null,
                'note' => $note,
                'created_at' => now()->subDays(rand(1, 90)), // Tạo trong 90 ngày qua
                'updated_at' => now()->subDays(rand(1, 90)),
            ];
        }

        foreach ($tuitions as $tuition) {
            Tuition::create($tuition);
        }

        $this->command->info('Đã tạo ' . count($tuitions) . ' bản ghi tuition mẫu.');
    }
}
