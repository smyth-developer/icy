<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Repositories\Contracts\LocationRepositoryInterface;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $location = [
            [
                'name' => 'Trảng Dài',
                'address' => 'Biên Hòa, Đồng Nai',
                'created_by' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ho Chi Minh',
                'address' => 'Tan Binh, Ho Chi Minh',
                'created_by' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($location as $item) {
            app(LocationRepositoryInterface::class)->create($item);
        }
    }
}
