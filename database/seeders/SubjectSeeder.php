<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Repositories\Contracts\SubjectRepositoryInterface;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            // Anh ngữ mẫu giáo (Kindergarten)
            [
            'program_id' => 1,
            'ordering' => 1,
            'name' => 'ICY Wonderland 1',
            'code' => 'IW1',
            'description' => 'Anh ngữ mẫu giáo (Kindergarten) - ICY Wonderland 1',
            ],
            [
            'program_id' => 1,
            'ordering' => 2,
            'name' => 'ICY Wonderland 2',
            'code' => 'IW2',
            'description' => 'Anh ngữ mẫu giáo (Kindergarten) - ICY Wonderland 2',
            ],
            [
            'program_id' => 1,
            'ordering' => 3,
            'name' => 'ICY Wonderland 3',
            'code' => 'IW3',
            'description' => 'Anh ngữ mẫu giáo (Kindergarten) - ICY Wonderland 3',
            ],
            [
            'program_id' => 1,
            'ordering' => 4,
            'name' => 'ICY Wonderland 4',
            'code' => 'IW4',
            'description' => 'Anh ngữ mẫu giáo (Kindergarten) - ICY Wonderland 4',
            ],
            [
            'program_id' => 1,
            'ordering' => 5,
            'name' => 'ICY Wonderland 5',
            'code' => 'IW5',
            'description' => 'Anh ngữ mẫu giáo (Kindergarten) - ICY Wonderland 5',
            ],
            [
            'program_id' => 1,
            'ordering' => 6,
            'name' => 'ICY Wonderland 6',
            'code' => 'IW6',
            'description' => 'Anh ngữ mẫu giáo (Kindergarten) - ICY Wonderland 6',
            ],

            // Anh ngữ thiếu nhi (Kids)
            [
            'program_id' => 2,
            'ordering' => 1,
            'name' => 'ICY Starters 1',
            'code' => 'IS1',
            'description' => 'Anh ngữ thiếu nhi (Kids) - ICY Starters 1',
            ],
            [
            'program_id' => 2,
            'ordering' => 2,
            'name' => 'ICY Starters 2',
            'code' => 'IS2',
            'description' => 'Anh ngữ thiếu nhi (Kids) - ICY Starters 2',
            ],
            [
            'program_id' => 2,
            'ordering' => 3,
            'name' => 'ICY Starters 3',
            'code' => 'IS3',
            'description' => 'Anh ngữ thiếu nhi (Kids) - ICY Starters 3',
            ],
            [
            'program_id' => 2,
            'ordering' => 4,
            'name' => 'ICY Starters 4',
            'code' => 'IS4',
            'description' => 'Anh ngữ thiếu nhi (Kids) - ICY Starters 4',
            ],
            [
            'program_id' => 2,
            'ordering' => 5,
            'name' => 'ICY Movers 1',
            'code' => 'IM1',
            'description' => 'Anh ngữ thiếu nhi (Kids) - ICY Movers 1',
            ],
            [
            'program_id' => 2,
            'ordering' => 6,
            'name' => 'ICY Movers 2',
            'code' => 'IM2',
            'description' => 'Anh ngữ thiếu nhi (Kids) - ICY Movers 2',
            ],
            [
            'program_id' => 2,
            'ordering' => 7,
            'name' => 'ICY Movers 3',
            'code' => 'IM3',
            'description' => 'Anh ngữ thiếu nhi (Kids) - ICY Movers 3',
            ],
            [
            'program_id' => 2,
            'ordering' => 8,
            'name' => 'ICY Movers 4',
            'code' => 'IM4',
            'description' => 'Anh ngữ thiếu nhi (Kids) - ICY Movers 4',
            ],
            [
            'program_id' => 2,
            'ordering' => 9,
            'name' => 'ICY Flyers 1',
            'code' => 'IF1',
            'description' => 'Anh ngữ thiếu nhi (Kids) - ICY Flyers 1',
            ],
            [
            'program_id' => 2,
            'ordering' => 10,
            'name' => 'ICY Flyers 2',
            'code' => 'IF2',
            'description' => 'Anh ngữ thiếu nhi (Kids) - ICY Flyers 2',
            ],
            [
            'program_id' => 2,
            'ordering' => 11,
            'name' => 'ICY Flyers 3',
            'code' => 'IF3',
            'description' => 'Anh ngữ thiếu nhi (Kids) - ICY Flyers 3',
            ],
            [
            'program_id' => 2,
            'ordering' => 12,
            'name' => 'ICY Flyers 4',
            'code' => 'IF4',
            'description' => 'Anh ngữ thiếu nhi (Kids) - ICY Flyers 4',
            ],

            // Anh ngữ thiếu niên (Teenager's English)
            [
            'program_id' => 3,
            'ordering' => 1,
            'name' => 'ICY Teen 1',
            'code' => 'IT1',
            'description' => "Anh ngữ thiếu niên (Teenager's English) - ICY Teen 1",
            ],
            [
            'program_id' => 3,
            'ordering' => 2,
            'name' => 'ICY Teen 2',
            'code' => 'IT2',
            'description' => "Anh ngữ thiếu niên (Teenager's English) - ICY Teen 2",
            ],
            [
            'program_id' => 3,
            'ordering' => 3,
            'name' => 'ICY Teen 3',
            'code' => 'IT3',
            'description' => "Anh ngữ thiếu niên (Teenager's English) - ICY Teen 3",
            ],
            [
            'program_id' => 3,
            'ordering' => 4,
            'name' => 'ICY Teen 4',
            'code' => 'IT4',
            'description' => "Anh ngữ thiếu niên (Teenager's English) - ICY Teen 4",
            ],
            [
            'program_id' => 3,
            'ordering' => 5,
            'name' => 'ICY Teen 5',
            'code' => 'IT5',
            'description' => "Anh ngữ thiếu niên (Teenager's English) - ICY Teen 5",
            ],
            [
            'program_id' => 3,
            'ordering' => 6,
            'name' => 'ICY Teen 6',
            'code' => 'IT6',
            'description' => "Anh ngữ thiếu niên (Teenager's English) - ICY Teen 6",
            ],
            [
            'program_id' => 3,
            'ordering' => 7,
            'name' => 'ICY Teen 7',
            'code' => 'IT7',
            'description' => "Anh ngữ thiếu niên (Teenager's English) - ICY Teen 7",
            ],
            [
            'program_id' => 3,
            'ordering' => 8,
            'name' => 'ICY Teen 8',
            'code' => 'IT8',
            'description' => "Anh ngữ thiếu niên (Teenager's English) - ICY Teen 8",
            ],

            // Anh ngữ giao tiếp (English for Communication)
            [
            'program_id' => 4,
            'ordering' => 1,
            'name' => 'ICY Communication 1',
            'code' => 'IC1',
            'description' => 'Anh ngữ giao tiếp (English for Communication) - ICY Communication 1',
            ],
            [
            'program_id' => 4,
            'ordering' => 2,
            'name' => 'ICY Communication 2',
            'code' => 'IC2',
            'description' => 'Anh ngữ giao tiếp (English for Communication) - ICY Communication 2',
            ],
            [
            'program_id' => 4,
            'ordering' => 3,
            'name' => 'ICY Communication 3',
            'code' => 'IC3',
            'description' => 'Anh ngữ giao tiếp (English for Communication) - ICY Communication 3',
            ],
            [
            'program_id' => 4,
            'ordering' => 4,
            'name' => 'ICY Communication 4',
            'code' => 'IC4',
            'description' => 'Anh ngữ giao tiếp (English for Communication) - ICY Communication 4',
            ],
            [
            'program_id' => 4,
            'ordering' => 5,
            'name' => 'ICY Communication 5',
            'code' => 'IC5',
            'description' => 'Anh ngữ giao tiếp (English for Communication) - ICY Communication 5',
            ],
            [
            'program_id' => 4,
            'ordering' => 6,
            'name' => 'ICY Communication 6',
            'code' => 'IC6',
            'description' => 'Anh ngữ giao tiếp (English for Communication) - ICY Communication 6',
            ],
            [
            'program_id' => 4,
            'ordering' => 7,
            'name' => 'ICY Communication 7',
            'code' => 'IC7',
            'description' => 'Anh ngữ giao tiếp (English for Communication) - ICY Communication 7',
            ],
            [
            'program_id' => 4,
            'ordering' => 8,
            'name' => 'ICY Communication 8',
            'code' => 'IC8',
            'description' => 'Anh ngữ giao tiếp (English for Communication) - ICY Communication 8',
            ],
            [
            'program_id' => 4,
            'ordering' => 9,
            'name' => 'ICY Communication 9',
            'code' => 'IC9',
            'description' => 'Anh ngữ giao tiếp (English for Communication) - ICY Communication 9',
            ],

            // Anh ngữ doanh nghiệp (English for Business)
            [
            'program_id' => 5,
            'ordering' => 1,
            'name' => 'ICY Business 1',
            'code' => 'IB1',
            'description' => 'Anh ngữ doanh nghiệp (English for Business) - ICY Business 1',
            ],
            [
            'program_id' => 5,
            'ordering' => 2,
            'name' => 'ICY Business 2',
            'code' => 'IB2',
            'description' => 'Anh ngữ doanh nghiệp (English for Business) - ICY Business 2',
            ],
            [
            'program_id' => 5,
            'ordering' => 3,
            'name' => 'ICY Business 3',
            'code' => 'IB3',
            'description' => 'Anh ngữ doanh nghiệp (English for Business) - ICY Business 3',
            ],
            [
            'program_id' => 5,
            'ordering' => 4,
            'name' => 'ICY Expertise 1',
            'code' => 'IE1',
            'description' => 'Anh ngữ doanh nghiệp (English for Business) - ICY Expertise 1',
            ],
            [
            'program_id' => 5,
            'ordering' => 5,
            'name' => 'ICY Expertise 2',
            'code' => 'IE2',
            'description' => 'Anh ngữ doanh nghiệp (English for Business) - ICY Expertise 2',
            ],
            [
            'program_id' => 5,
            'ordering' => 6,
            'name' => 'ICY Expertise 3',
            'code' => 'IE3',
            'description' => 'Anh ngữ doanh nghiệp (English for Business) - ICY Expertise 3',
            ],
            [
            'program_id' => 5,
            'ordering' => 7,
            'name' => 'ICY Proficiency 1',
            'code' => 'IP1',
            'description' => 'Anh ngữ doanh nghiệp (English for Business) - ICY Proficiency 1',
            ],
            [
            'program_id' => 5,
            'ordering' => 8,
            'name' => 'ICY Proficiency 2',
            'code' => 'IP2',
            'description' => 'Anh ngữ doanh nghiệp (English for Business) - ICY Proficiency 2',
            ],

            // Chứng chỉ IELTS (Ielts Achievers)
            [
            'program_id' => 6,
            'ordering' => 1,
            'name' => 'ICY Foundation',
            'code' => 'FO',
            'description' => 'Chứng chỉ IELTS (Ielts Achievers) - ICY Foundation',
            ],
            [
            'program_id' => 6,
            'ordering' => 2,
            'name' => 'ICY Freshman',
            'code' => 'FR',
            'description' => 'Chứng chỉ IELTS (Ielts Achievers) - ICY Freshman',
            ],
            [
            'program_id' => 6,
            'ordering' => 3,
            'name' => 'ICY Sophomore',
            'code' => 'SO',
            'description' => 'Chứng chỉ IELTS (Ielts Achievers) - ICY Sophomore',
            ],
            [
            'program_id' => 6,
            'ordering' => 4,
            'name' => 'ICY Junior 1',
            'code' => 'JR1',
            'description' => 'Chứng chỉ IELTS (Ielts Achievers) - ICY Junior 1',
            ],
            [
            'program_id' => 6,
            'ordering' => 5,
            'name' => 'ICY Junior 2',
            'code' => 'JR2',
            'description' => 'Chứng chỉ IELTS (Ielts Achievers) - ICY Junior 2',
            ],
            [
            'program_id' => 6,
            'ordering' => 6,
            'name' => 'ICY Pre-Senior',
            'code' => 'PS1',
            'description' => 'Chứng chỉ IELTS (Ielts Achievers) - ICY Pre-Senior',
            ],
            [
            'program_id' => 6,
            'ordering' => 7,
            'name' => 'ICY Senior 1',
            'code' => 'SR1',
            'description' => 'Chứng chỉ IELTS (Ielts Achievers) - ICY Senior 1',
            ],
            [
            'program_id' => 6,
            'ordering' => 8,
            'name' => 'ICY Senior 2',
            'code' => 'SR2',
            'description' => 'Chứng chỉ IELTS (Ielts Achievers) - ICY Senior 2',
            ],

            // Luyện thi vào 10 (Highschool Entrance)
            [
            'program_id' => 7,
            'ordering' => 1,
            'name' => 'ICY Highschool 1',
            'code' => 'IH1',
            'description' => 'Luyện thi vào 10 (Highschool Entrance) - ICY Highschool 1',
            ],
            [
            'program_id' => 7,
            'ordering' => 2,
            'name' => 'ICY Highschool 2',
            'code' => 'IH2',
            'description' => 'Luyện thi vào 10 (Highschool Entrance) - ICY Highschool 2',
            ],
            [
            'program_id' => 7,
            'ordering' => 3,
            'name' => 'ICY Highschool 3',
            'code' => 'IH3',
            'description' => 'Luyện thi vào 10 (Highschool Entrance) - ICY Highschool 3',
            ],
            [
            'program_id' => 7,
            'ordering' => 4,
            'name' => 'ICY Highschool 4',
            'code' => 'IH4',
            'description' => 'Luyện thi vào 10 (Highschool Entrance) - ICY Highschool 4',
            ],
            [
            'program_id' => 7,
            'ordering' => 5,
            'name' => 'ICY Highschool 5',
            'code' => 'IH5',
            'description' => 'Luyện thi vào 10 (Highschool Entrance) - ICY Highschool 5',
            ],
            [
            'program_id' => 7,
            'ordering' => 6,
            'name' => 'ICY Highschool 6',
            'code' => 'IH6',
            'description' => 'Luyện thi vào 10 (Highschool Entrance) - ICY Highschool 6',
            ],

            // Luyện thi THPTQG (Higher Education Entrance)
            [
            'program_id' => 8,
            'ordering' => 1,
            'name' => 'ICY Unicollege 1',
            'code' => 'IU1',
            'description' => 'Luyện thi THPTQG (Higher Education Entrance) - ICY Unicollege 1',
            ],
            [
            'program_id' => 8,
            'ordering' => 2,
            'name' => 'ICY Unicollege 2',
            'code' => 'IU2',
            'description' => 'Luyện thi THPTQG (Higher Education Entrance) - ICY Unicollege 2',
            ],
            [
            'program_id' => 8,
            'ordering' => 3,
            'name' => 'ICY Unicollege 3',
            'code' => 'IU3',
            'description' => 'Luyện thi THPTQG (Higher Education Entrance) - ICY Unicollege 3',
            ],
            [
            'program_id' => 8,
            'ordering' => 4,
            'name' => 'ICY Unicollege 4',
            'code' => 'IU4',
            'description' => 'Luyện thi THPTQG (Higher Education Entrance) - ICY Unicollege 4',
            ],
            [
            'program_id' => 8,
            'ordering' => 5,
            'name' => 'ICY Unicollege 5',
            'code' => 'IU5',
            'description' => 'Luyện thi THPTQG (Higher Education Entrance) - ICY Unicollege 5',
            ],
            [
            'program_id' => 8,
            'ordering' => 6,
            'name' => 'ICY Unicollege 6',
            'code' => 'IU6',
            'description' => 'Luyện thi THPTQG (Higher Education Entrance) - ICY Unicollege 6',
            ],

            // Anh ngữ trường học (English for Schools)
            [
            'program_id' => 9,
            'ordering' => 1,
            'name' => 'ICY Academy',
            'code' => 'IA',
            'description' => 'Anh ngữ trường học (English for Schools) - ICY Academy',
            ],
        ];

        foreach ($subjects as $subject) {
            app(SubjectRepositoryInterface::class)->create($subject);
        }
    }
}
