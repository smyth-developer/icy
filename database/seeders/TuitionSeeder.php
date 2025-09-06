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
        })->take(5)->get();
        $programs = Program::all();
        $seasons = Season::all();
        $banks = Bank::all();

        if ($users->isEmpty() || $programs->isEmpty() || $seasons->isEmpty()) {
            $this->command->info('Không có đủ dữ liệu để tạo tuition. Vui lòng chạy các seeder khác trước.');
            return;
        }

        $tuitions = [
            [
                'user_id' => $users->first()->id,
                'receipt_number' => 'RCP001',
                'program_id' => $programs->first()->id,
                'season_id' => $seasons->first()->id,
                'price' => 1500000,
                'status' => 'paid',
                'payment_method' => 'cash',
                'bank_id' => null,
                'note' => 'Đóng học phí kỳ 1',
            ],
            [
                'user_id' => $users->skip(1)->first()->id ?? $users->first()->id,
                'receipt_number' => 'RCP002',
                'program_id' => $programs->skip(1)->first()->id ?? $programs->first()->id,
                'season_id' => $seasons->first()->id,
                'price' => 1800000,
                'status' => 'paid',
                'payment_method' => 'bank_transfer',
                'bank_id' => $banks->first()->id ?? null,
                'note' => 'Chuyển khoản ngân hàng',
            ],
            [
                'user_id' => $users->skip(2)->first()->id ?? $users->first()->id,
                'receipt_number' => 'RCP003',
                'program_id' => $programs->skip(2)->first()->id ?? $programs->first()->id,
                'season_id' => $seasons->first()->id,
                'price' => 1950000,
                'status' => 'pending',
                'payment_method' => 'cash',
                'bank_id' => null,
                'note' => 'Chờ xác nhận',
            ],
            [
                'user_id' => $users->skip(3)->first()->id ?? $users->first()->id,
                'receipt_number' => 'RCP004',
                'program_id' => $programs->skip(3)->first()->id ?? $programs->first()->id,
                'season_id' => $seasons->first()->id,
                'price' => 2100000,
                'status' => 'failed',
                'payment_method' => 'bank_transfer',
                'bank_id' => $banks->first()->id ?? null,
                'note' => 'Giao dịch thất bại',
            ],
            [
                'user_id' => $users->skip(4)->first()->id ?? $users->first()->id,
                'receipt_number' => 'RCP005',
                'program_id' => $programs->skip(4)->first()->id ?? $programs->first()->id,
                'season_id' => $seasons->first()->id,
                'price' => 2400000,
                'status' => 'paid',
                'payment_method' => 'cash',
                'bank_id' => null,
                'note' => 'Đóng học phí IELTS',
            ],
        ];

        foreach ($tuitions as $tuition) {
            Tuition::create($tuition);
        }

        $this->command->info('Đã tạo ' . count($tuitions) . ' bản ghi tuition mẫu.');
    }
}
