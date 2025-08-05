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
            'english_name' => 'Kindergarten',
            ],
            [
            'name' => 'Anh ngữ thiếu nhi',
            'english_name' => 'Kids',
            ],
            [
            'name' => 'Anh ngữ thiếu niên',
            'english_name' => "Teenager's English",
            ],
            [
            'name' => 'Anh ngữ giao tiếp',
            'english_name' => 'English for Communication',
            ],
            [
            'name' => 'Anh ngữ doanh nghiệp',
            'english_name' => 'English for Business',
            ],
            [
            'name' => 'Chứng chỉ IELTS',
            'english_name' => 'Ielts Achievers',
            ],
            [
            'name' => 'Luyện thi vào lớp 10',
            'english_name' => 'Highschool Entrance',
            ],
            [
            'name' => 'Luyện thi THPT Quốc Gia',
            'english_name' => 'Higher Education Entrance',
            ],
            [
            'name' => 'Anh ngữ trường học',
            'english_name' => 'English for Schools',
            ]
        ];

        foreach ($programs as $program) {
            app(ProgramRepositoryInterface::class)->create([
                'name' => $program['name'],
                'english_name' => $program['english_name']
            ]);
        }
    }
}
