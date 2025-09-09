<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramLocationPrice;

class ProgramLocationPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả programs và locations
        $programs = \App\Models\Program::all();
        $locations = \App\Models\Location::all();

        // Định nghĩa giá cho từng chương trình
        $programPrices = [
            1 => 1500000, // Anh ngữ mẫu giáo (Kindergarten)
            2 => 1800000, // Anh ngữ thiếu nhi (Kids)
            3 => 1950000, // Anh ngữ thiếu niên (Teenager's English)
            4 => 2100000, // Anh ngữ giao tiếp (English for Communication)
            5 => 4500000, // Anh ngữ doanh nghiệp (English for Business)
            6 => 2400000, // Chứng chỉ IELTS (IELTS Achievers)
            7 => 2100000, // Luyện thi vào 10 (Highschool Entrance)
            8 => 2100000, // Luyện thi THPTQG (Higher Education Entrance)
        ];

        // Tạo dữ liệu cho tất cả combinations của program và location
        foreach ($programs as $program) {
            foreach ($locations as $location) {
                // Kiểm tra xem đã tồn tại chưa
                $existing = ProgramLocationPrice::where('program_id', $program->id)
                    ->where('location_id', $location->id)
                    ->first();

                if (!$existing) {
                    ProgramLocationPrice::create([
                        'program_id' => $program->id,
                        'location_id' => $location->id,
                        'price' => $programPrices[$program->id] ?? 1000000, // Default price nếu không có trong list
                    ]);
                }
            }
        }
    }
}
