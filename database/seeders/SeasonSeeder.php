<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Repositories\Contracts\SeasonRepositoryInterface;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $season = [
            [
                'name' => 'Spring 2025',
                'code' => 'SP25',
                'start_date' => '2025-01-01',
                'end_date' => '2025-03-31',
                'status' => 'finished',
                'note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Summer 2025',
                'code' => 'SU25',
                'start_date' => '2025-04-01',
                'end_date' => '2025-06-30',
                'status' => 'ongoing',
                'note' => 'Lớp hè tăng cường',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fall 2025',
                'code' => 'FA25',
                'start_date' => '2025-07-01',
                'end_date' => '2025-09-30',
                'status' => 'upcoming',
                'note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Winter 2025',
                'code' => 'WI25',
                'start_date' => '2025-10-01',
                'end_date' => '2025-12-31',
                'status' => 'upcoming',
                'note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($season as $item) {
            app(SeasonRepositoryInterface::class)->create($item);
        }
    }
}
