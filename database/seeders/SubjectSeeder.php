<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Models\Program;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy các program
        $kindergarten = Program::where('name', 'Anh ngữ mẫu giáo')->first();
        $kids = Program::where('name', 'Anh ngữ thiếu nhi')->first();
        $teenager = Program::where('name', 'Anh ngữ thiếu niên')->first();
        $communication = Program::where('name', 'Anh ngữ giao tiếp')->first();
        $business = Program::where('name', 'Anh ngữ doanh nghiệp')->first();
        $ielts = Program::where('name', 'Chứng chỉ IELTS')->first();
        $highschool = Program::where('name', 'Luyện thi vào lớp 10')->first();
        $thptqg = Program::where('name', 'Luyện thi THPT Quốc Gia')->first();

        $subjects = [
            // Anh ngữ mẫu giáo (Kindergarten) - HS mẫu giáo
            [
                'program_id' => $kindergarten->id,
                'name' => 'ICY Wonderland 1',
                'code' => 'IW1',
                'description' => 'Làm quen với tiếng Anh qua các hoạt động vui nhộn cho trẻ mẫu giáo',
                'ordering' => 1,
            ],
            [
                'program_id' => $kindergarten->id,
                'name' => 'ICY Wonderland 2',
                'code' => 'IW2',
                'description' => 'Phát triển từ vựng cơ bản và phát âm cho trẻ mẫu giáo',
                'ordering' => 2,
            ],
            [
                'program_id' => $kindergarten->id,
                'name' => 'ICY Wonderland 3',
                'code' => 'IW3',
                'description' => 'Học các câu giao tiếp đơn giản cho trẻ mẫu giáo',
                'ordering' => 3,
            ],
            [
                'program_id' => $kindergarten->id,
                'name' => 'ICY Wonderland 4',
                'code' => 'IW4',
                'description' => 'Luyện tập nghe và nói cơ bản cho trẻ mẫu giáo',
                'ordering' => 4,
            ],
            [
                'program_id' => $kindergarten->id,
                'name' => 'ICY Wonderland 5',
                'code' => 'IW5',
                'description' => 'Mở rộng vốn từ và câu cho trẻ mẫu giáo',
                'ordering' => 5,
            ],
            [
                'program_id' => $kindergarten->id,
                'name' => 'ICY Wonderland 6',
                'code' => 'IW6',
                'description' => 'Hoàn thiện kỹ năng giao tiếp cơ bản cho trẻ mẫu giáo',
                'ordering' => 6,
            ],

            // Anh ngữ thiếu nhi (Kids) - HS cấp 1
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 1',
                'code' => 'IK1',
                'description' => 'Nền tảng tiếng Anh cho học sinh cấp 1',
                'ordering' => 1,
            ],
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 2',
                'code' => 'IK2',
                'description' => 'Phát triển từ vựng và ngữ pháp cơ bản cho học sinh cấp 1',
                'ordering' => 2,
            ],
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 3',
                'code' => 'IK3',
                'description' => 'Luyện tập đọc hiểu và viết câu đơn cho học sinh cấp 1',
                'ordering' => 3,
            ],
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 4',
                'code' => 'IK4',
                'description' => 'Mở rộng kỹ năng nghe và nói cho học sinh cấp 1',
                'ordering' => 4,
            ],
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 5',
                'code' => 'IK5',
                'description' => 'Học ngữ pháp nâng cao cho học sinh cấp 1',
                'ordering' => 5,
            ],
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 6',
                'code' => 'IK6',
                'description' => 'Luyện tập viết đoạn văn ngắn cho học sinh cấp 1',
                'ordering' => 6,
            ],
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 7',
                'code' => 'IK7',
                'description' => 'Phát triển kỹ năng đọc hiểu cho học sinh cấp 1',
                'ordering' => 7,
            ],
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 8',
                'code' => 'IK8',
                'description' => 'Luyện tập nghe hiểu nâng cao cho học sinh cấp 1',
                'ordering' => 8,
            ],
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 9',
                'code' => 'IK9',
                'description' => 'Học từ vựng chuyên sâu cho học sinh cấp 1',
                'ordering' => 9,
            ],
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 10',
                'code' => 'IK10',
                'description' => 'Luyện tập giao tiếp thực tế cho học sinh cấp 1',
                'ordering' => 10,
            ],
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 11',
                'code' => 'IK11',
                'description' => 'Ôn tập và củng cố kiến thức cho học sinh cấp 1',
                'ordering' => 11,
            ],
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 12',
                'code' => 'IK12',
                'description' => 'Chuẩn bị chuyển cấp cho học sinh cấp 1',
                'ordering' => 12,
            ],
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 13',
                'code' => 'IK13',
                'description' => 'Luyện thi chứng chỉ quốc tế cho học sinh cấp 1',
                'ordering' => 13,
            ],
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 14',
                'code' => 'IK14',
                'description' => 'Thực hành kỹ năng tổng hợp cho học sinh cấp 1',
                'ordering' => 14,
            ],
            [
                'program_id' => $kids->id,
                'name' => 'ICY Kids 15',
                'code' => 'IK15',
                'description' => 'Hoàn thiện chương trình Kids cho học sinh cấp 1',
                'ordering' => 15,
            ],

            // Anh ngữ thiếu niên (Teenager's English) - HS cấp 2
            [
                'program_id' => $teenager->id,
                'name' => 'ICY Teen 1',
                'code' => 'IT1',
                'description' => 'Nền tảng tiếng Anh cho học sinh cấp 2',
                'ordering' => 1,
            ],
            [
                'program_id' => $teenager->id,
                'name' => 'ICY Teen 2',
                'code' => 'IT2',
                'description' => 'Phát triển ngữ pháp và từ vựng cho học sinh cấp 2',
                'ordering' => 2,
            ],
            [
                'program_id' => $teenager->id,
                'name' => 'ICY Teen 3',
                'code' => 'IT3',
                'description' => 'Luyện tập kỹ năng đọc hiểu cho học sinh cấp 2',
                'ordering' => 3,
            ],
            [
                'program_id' => $teenager->id,
                'name' => 'ICY Teen 4',
                'code' => 'IT4',
                'description' => 'Phát triển kỹ năng viết cho học sinh cấp 2',
                'ordering' => 4,
            ],
            [
                'program_id' => $teenager->id,
                'name' => 'ICY Teen 5',
                'code' => 'IT5',
                'description' => 'Luyện tập nghe hiểu nâng cao cho học sinh cấp 2',
                'ordering' => 5,
            ],
            [
                'program_id' => $teenager->id,
                'name' => 'ICY Teen 6',
                'code' => 'IT6',
                'description' => 'Phát triển kỹ năng nói cho học sinh cấp 2',
                'ordering' => 6,
            ],
            [
                'program_id' => $teenager->id,
                'name' => 'ICY Teen 7',
                'code' => 'IT7',
                'description' => 'Tổng hợp và ôn tập kiến thức cho học sinh cấp 2',
                'ordering' => 7,
            ],
            [
                'program_id' => $teenager->id,
                'name' => 'ICY Teen 8',
                'code' => 'IT8',
                'description' => 'Chuẩn bị chuyển cấp lên THPT cho học sinh cấp 2',
                'ordering' => 8,
            ],

            // Anh ngữ giao tiếp (English for Communication) - 15+ (NGHE-NÓI)
            [
                'program_id' => $communication->id,
                'name' => 'ICY Communication 1',
                'code' => 'IC1',
                'description' => 'Giao tiếp cơ bản trong cuộc sống hàng ngày - tập trung nghe nói',
                'ordering' => 1,
            ],
            [
                'program_id' => $communication->id,
                'name' => 'ICY Communication 2',
                'code' => 'IC2',
                'description' => 'Giao tiếp trong môi trường xã hội - tập trung nghe nói',
                'ordering' => 2,
            ],
            [
                'program_id' => $communication->id,
                'name' => 'ICY Communication 3',
                'code' => 'IC3',
                'description' => 'Giao tiếp trong công việc - tập trung nghe nói',
                'ordering' => 3,
            ],
            [
                'program_id' => $communication->id,
                'name' => 'ICY Communication 4',
                'code' => 'IC4',
                'description' => 'Giao tiếp trong du lịch - tập trung nghe nói',
                'ordering' => 4,
            ],
            [
                'program_id' => $communication->id,
                'name' => 'ICY Communication 5',
                'code' => 'IC5',
                'description' => 'Giao tiếp trong học tập - tập trung nghe nói',
                'ordering' => 5,
            ],
            [
                'program_id' => $communication->id,
                'name' => 'ICY Communication 6',
                'code' => 'IC6',
                'description' => 'Giao tiếp trong y tế - tập trung nghe nói',
                'ordering' => 6,
            ],
            [
                'program_id' => $communication->id,
                'name' => 'ICY Communication 7',
                'code' => 'IC7',
                'description' => 'Giao tiếp trong kinh doanh - tập trung nghe nói',
                'ordering' => 7,
            ],
            [
                'program_id' => $communication->id,
                'name' => 'ICY Communication 8',
                'code' => 'IC8',
                'description' => 'Giao tiếp trong văn hóa - tập trung nghe nói',
                'ordering' => 8,
            ],
            [
                'program_id' => $communication->id,
                'name' => 'ICY Communication 9',
                'code' => 'IC9',
                'description' => 'Giao tiếp nâng cao - tập trung nghe nói',
                'ordering' => 9,
            ],
            [
                'program_id' => $communication->id,
                'name' => 'ICY Communication 10',
                'code' => 'IC10',
                'description' => 'Thành thạo giao tiếp tiếng Anh - tập trung nghe nói',
                'ordering' => 10,
            ],

            // Anh ngữ doanh nghiệp (English for Business) - Doanh nghiệp
            [
                'program_id' => $business->id,
                'name' => 'ICY Business 1',
                'code' => 'IB1',
                'description' => 'Tiếng Anh cơ bản trong doanh nghiệp',
                'ordering' => 1,
            ],
            [
                'program_id' => $business->id,
                'name' => 'ICY Business 2',
                'code' => 'IB2',
                'description' => 'Giao tiếp trong họp hành doanh nghiệp',
                'ordering' => 2,
            ],
            [
                'program_id' => $business->id,
                'name' => 'ICY Business 3',
                'code' => 'IB3',
                'description' => 'Thuyết trình và báo cáo doanh nghiệp',
                'ordering' => 3,
            ],
            [
                'program_id' => $business->id,
                'name' => 'ICY Business 4',
                'code' => 'IB4',
                'description' => 'Đàm phán và thương lượng doanh nghiệp',
                'ordering' => 4,
            ],
            [
                'program_id' => $business->id,
                'name' => 'ICY Business 5',
                'code' => 'IB5',
                'description' => 'Viết email và tài liệu kinh doanh',
                'ordering' => 5,
            ],
            [
                'program_id' => $business->id,
                'name' => 'ICY Business 6',
                'code' => 'IB6',
                'description' => 'Giao tiếp với khách hàng doanh nghiệp',
                'ordering' => 6,
            ],
            [
                'program_id' => $business->id,
                'name' => 'ICY Business 7',
                'code' => 'IB7',
                'description' => 'Quản lý dự án bằng tiếng Anh doanh nghiệp',
                'ordering' => 7,
            ],
            [
                'program_id' => $business->id,
                'name' => 'ICY Business 8',
                'code' => 'IB8',
                'description' => 'Lãnh đạo và quản lý nhóm doanh nghiệp',
                'ordering' => 8,
            ],
            [
                'program_id' => $business->id,
                'name' => 'ICY Business 9',
                'code' => 'IB9',
                'description' => 'Thành thạo tiếng Anh doanh nghiệp',
                'ordering' => 9,
            ],

            // Chứng chỉ IELTS (IELTS Achievers) - Cơ bản đến nâng cao
            [
                'program_id' => $ielts->id,
                'name' => 'ICY Ielts 1',
                'code' => 'II1',
                'description' => 'Cơ bản: Từ vựng chủ đề, ngữ pháp căn bản, Grammar, Vocabulary, IPA',
                'ordering' => 1,
            ],
            [
                'program_id' => $ielts->id,
                'name' => 'ICY Ielts 2',
                'code' => 'II2',
                'description' => 'Cơ bản: Từ vựng chủ đề, ngữ pháp căn bản, Grammar, Vocabulary, IPA',
                'ordering' => 2,
            ],
            [
                'program_id' => $ielts->id,
                'name' => 'ICY Ielts 3',
                'code' => 'II3',
                'description' => 'Làm quen với Ielts: Hackers for listening/reading, các câu writing ngắn, speaking part 1',
                'ordering' => 3,
            ],
            [
                'program_id' => $ielts->id,
                'name' => 'ICY Ielts 4',
                'code' => 'II4',
                'description' => 'Làm quen với Ielts: Hackers for listening/reading, writing task 1, speaking part 2',
                'ordering' => 4,
            ],
            [
                'program_id' => $ielts->id,
                'name' => 'ICY Ielts 5',
                'code' => 'II5',
                'description' => 'Làm quen với Ielts: Hackers for listening/reading, writing task 2, speaking part 2,3',
                'ordering' => 5,
            ],
            [
                'program_id' => $ielts->id,
                'name' => 'ICY Ielts 6',
                'code' => 'II6',
                'description' => 'Chuyên sâu về Ielts: Giải đề full bài theo từng kĩ năng (Ielts Mock Test)',
                'ordering' => 6,
            ],
            [
                'program_id' => $ielts->id,
                'name' => 'ICY Ielts 7',
                'code' => 'II7',
                'description' => 'Chuyên sâu về Ielts: Ôn tập lại từ vựng, Full đề thi',
                'ordering' => 7,
            ],
            [
                'program_id' => $ielts->id,
                'name' => 'ICY Ielts 8',
                'code' => 'II8',
                'description' => 'Chuyên sâu về Ielts: Ôn tập lại từ vựng, Full đề thi',
                'ordering' => 8,
            ],

            // Luyện thi vào 10 (Highschool Entrance) - HS thi vào 10
            [
                'program_id' => $highschool->id,
                'name' => 'ICY Highschool 1',
                'code' => 'IH1',
                'description' => 'Nền tảng tiếng Anh cho kỳ thi vào lớp 10',
                'ordering' => 1,
            ],
            [
                'program_id' => $highschool->id,
                'name' => 'ICY Highschool 2',
                'code' => 'IH2',
                'description' => 'Ngữ pháp và từ vựng trọng tâm cho kỳ thi vào lớp 10',
                'ordering' => 2,
            ],
            [
                'program_id' => $highschool->id,
                'name' => 'ICY Highschool 3',
                'code' => 'IH3',
                'description' => 'Luyện tập đọc hiểu cho kỳ thi vào lớp 10',
                'ordering' => 3,
            ],
            [
                'program_id' => $highschool->id,
                'name' => 'ICY Highschool 4',
                'code' => 'IH4',
                'description' => 'Luyện tập viết câu và đoạn văn cho kỳ thi vào lớp 10',
                'ordering' => 4,
            ],
            [
                'program_id' => $highschool->id,
                'name' => 'ICY Highschool 5',
                'code' => 'IH5',
                'description' => 'Luyện tập nghe hiểu cho kỳ thi vào lớp 10',
                'ordering' => 5,
            ],
            [
                'program_id' => $highschool->id,
                'name' => 'ICY Highschool 6',
                'code' => 'IH6',
                'description' => 'Luyện đề và ôn tập tổng hợp cho kỳ thi vào lớp 10',
                'ordering' => 6,
            ],

            // Luyện thi THPTQG (Higher Education Entrance) - HS thi vào THPT QG
            [
                'program_id' => $thptqg->id,
                'name' => 'ICY Unicollege 1',
                'code' => 'IU1',
                'description' => 'Nền tảng tiếng Anh cho kỳ thi THPT Quốc gia',
                'ordering' => 1,
            ],
            [
                'program_id' => $thptqg->id,
                'name' => 'ICY Unicollege 2',
                'code' => 'IU2',
                'description' => 'Ngữ pháp nâng cao và từ vựng chuyên sâu cho kỳ thi THPT Quốc gia',
                'ordering' => 2,
            ],
            [
                'program_id' => $thptqg->id,
                'name' => 'ICY Unicollege 3',
                'code' => 'IU3',
                'description' => 'Luyện tập đọc hiểu nâng cao cho kỳ thi THPT Quốc gia',
                'ordering' => 3,
            ],
            [
                'program_id' => $thptqg->id,
                'name' => 'ICY Unicollege 4',
                'code' => 'IU4',
                'description' => 'Luyện tập viết luận và bài tập cho kỳ thi THPT Quốc gia',
                'ordering' => 4,
            ],
            [
                'program_id' => $thptqg->id,
                'name' => 'ICY Unicollege 5',
                'code' => 'IU5',
                'description' => 'Luyện tập nghe hiểu nâng cao cho kỳ thi THPT Quốc gia',
                'ordering' => 5,
            ],
            [
                'program_id' => $thptqg->id,
                'name' => 'ICY Unicollege 6',
                'code' => 'IU6',
                'description' => 'Luyện đề và chiến thuật làm bài cho kỳ thi THPT Quốc gia',
                'ordering' => 6,
            ],
        ];

        foreach ($subjects as $subject) {
            app(SubjectRepositoryInterface::class)->create($subject, $subject['program_id']);
        }
    }
}