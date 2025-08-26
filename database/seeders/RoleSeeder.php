<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Repositories\Contracts\RoleRepositoryInterface;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            [
                'name' => 'BOD',
                'description' => 'Board of Directors with full system access',
                'type' => 'System',
                'created_by' => '1',
            ],
            [
                'name' => 'Accountant',
                'description' => 'Accountant manage the financial transactions of the center',
                'type' => 'System',
                'created_by' => '1',
            ],
            [
                'name' => 'Center Manager',
                'description' => 'Manages center operations with administrative access',
                'type' => 'System',
                'created_by' => '1',
            ],
            [
                'name' => 'Receptionist',
                'description' => 'Handles front desk operations with specific permissions',
                'type' => 'System',
                'created_by' => '1',
            ],
            [
                'name' => 'Teacher',
                'description' => 'Responsible for teaching and managing classes',
                'type' => 'System',
                'created_by' => '1',
            ],
            [
                'name' => 'Student',
                'description' => 'Access to learning materials and class schedules',
                'type' => 'System',
                'created_by' => '1',
            ]
        ];

        foreach($role as $item)
        {
            app(RoleRepositoryInterface::class)->create($item);
        }
    }
}
