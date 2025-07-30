<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Repositories\Contracts\ProgramRepositoryInterface;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Anh ngữ mẫu giáo',
            ],
            [
                'name' => 'Anh ngữ thiếu nhi',
            ],
            [
                'name' => 'Anh ngữ thiếu niên',
            ],
            [
                'name' => 'Anh ngữ giao tiếp',
            ],
            [
                'name' => 'Chứng chỉ IELTS',
            ],
            [
                'name' => 'Luyện thi vào lớp 10',
            ],
            [
                'name' => 'Luyện thi THPT Quốc Gia',
            ],
            [
                'name' => 'Anh ngữ trường học',
            ],
            [
                'name' => 'Anh ngữ doanh nghiệp',
            ]
        ];

        foreach ($programs as $program) {
            app(ProgramRepositoryInterface::class)->create([
                'name' => $program['name'],
                'description' => 'Khóa học ' . $program['name']
            ]);
        }
    }
}
