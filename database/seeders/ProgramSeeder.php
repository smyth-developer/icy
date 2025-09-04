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
                'description' => 'Chương trình tiếng Anh cho trẻ từ 4–6 tuổi, giúp phát triển ngôn ngữ qua trò chơi và hình ảnh.',
                'price' => 1500000
            ],
            [
                'name' => 'Anh ngữ thiếu nhi',
                'english_name' => 'Kids',
                'description' => 'Dành cho học sinh từ 6–10 tuổi, tập trung vào từ vựng, phản xạ và phát âm chuẩn.',
                'price' => 1800000
            ],
            [
                'name' => 'Anh ngữ thiếu niên',
                'english_name' => "Teenager's English",
                'description' => 'Phát triển toàn diện 4 kỹ năng cho học sinh từ 11–15 tuổi, chuẩn bị cho các kỳ thi và giao tiếp thực tế.',
                'price' => 1950000
            ],
            [
                'name' => 'Anh ngữ giao tiếp',
                'english_name' => 'English for Communication',
                'description' => 'Chú trọng cải thiện khả năng nói và nghe, áp dụng trong các tình huống giao tiếp hàng ngày.',
                'price' => 2100000
            ],
            [
                'name' => 'Anh ngữ doanh nghiệp',
                'english_name' => 'English for Business',
                'description' => 'Phát triển kỹ năng giao tiếp tiếng Anh trong môi trường làm việc chuyên nghiệp, hội họp và viết email.',
                'price' => 4500000
            ],
            [
                'name' => 'Chứng chỉ IELTS',
                'english_name' => 'IELTS Achievers',
                'description' => 'Luyện thi IELTS theo band mục tiêu, tập trung chiến lược làm bài và kỹ năng học thuật.',
                'price' => 2400000
            ],
            [
                'name' => 'Luyện thi vào lớp 10',
                'english_name' => 'Highschool Entrance',
                'description' => 'Ôn tập kiến thức tiếng Anh trọng tâm để đạt kết quả cao trong kỳ thi tuyển sinh lớp 10.',
                'price' => 2100000
            ],
            [
                'name' => 'Luyện thi THPT Quốc Gia',
                'english_name' => 'Higher Education Entrance',
                'description' => 'Luyện thi tiếng Anh THPT Quốc gia với chiến lược làm bài và luyện đề sát thực tế.',
                'price' => 2100000
            ]
        ];


        foreach ($programs as $program) {
            app(ProgramRepositoryInterface::class)->create($program);
        }
    }
}
