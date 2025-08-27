<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            LocationSeeder::class,
            SeasonSeeder::class,
            RoleSeeder::class,
            ProgramSeeder::class,
            SubjectSeeder::class,
            BankSeeder::class,
        ]);

        DB::table('location_user')->insert([
            //BOD
            ['user_id' => 1, 'location_id' => 1],
            ['user_id' => 1, 'location_id' => 2],
            ['user_id' => 2, 'location_id' => 1],
            ['user_id' => 2, 'location_id' => 2],
            //Center Manager
            ['user_id' => 3, 'location_id' => 1],
            ['user_id' => 4, 'location_id' => 2],
            //Receptionist
            ['user_id' => 5, 'location_id' => 1],
            ['user_id' => 6, 'location_id' => 2],
            //Teacher
            ['user_id' => 7, 'location_id' => 1],
            ['user_id' => 8, 'location_id' => 2],
            //Student
            ['user_id' => 9, 'location_id' => 1],
            ['user_id' => 10, 'location_id' => 2],

        ]);

        DB::table('role_user')->insert([
            //BOD
            ['user_id' => 1, 'role_id' => 1],
            ['user_id' => 2, 'role_id' => 1],
            //Center Manager
            ['user_id' => 3, 'role_id' => 3],
            ['user_id' => 4, 'role_id' => 3],
            //Receptionist
            ['user_id' => 5, 'role_id' => 4],
            ['user_id' => 6, 'role_id' => 4],
            //Teacher
            ['user_id' => 7, 'role_id' => 5],
            ['user_id' => 8, 'role_id' => 5],
            //Student
            ['user_id' => 9, 'role_id' => 6],
            ['user_id' => 10, 'role_id' => 6],
        ]);

    }
}
