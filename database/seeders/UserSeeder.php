<?php

namespace Database\Seeders;

use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Nguyễn Khắc Huấn',
                'email' => 'huank@icy.edu.com',
                'username' => 'huannk',
                'account_code' => 'ICY00001',
                'status' => 'active',
                'password' => bcrypt('12345'),
                'must_change_password' => 0,
                'first_login_at' => now(),
                'last_password_change_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Nguyễn Đức Huỳnh',
                'email' => 'huynhnd@icy.edu.com',
                'username' => 'huynhnd',
                'account_code' => 'ICY00000',
                'status' => 'active',
                'password' => bcrypt('12345'),
                'must_change_password' => 0,
                'first_login_at' => now(),
                'last_password_change_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Manager Center TB',
                'email' => 'managertb@icy.edu.com',
                'username' => 'managertb',
                'account_code' => 'ICY00002',
                'status' => 'active',
                'password' => bcrypt('12345'),
                'must_change_password' => 0,
                'first_login_at' => now(),
                'last_password_change_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Manager Center HCM',
                'email' => 'managerhcm@icy.edu.com',
                'username' => 'managerhcm',
                'account_code' => 'ICY00003',
                'status' => 'active',
                'password' => bcrypt('12345'),
                'must_change_password' => 0,
                'first_login_at' => now(),
                'last_password_change_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Receptionist TB',
                'email' => 'receptionisttb@icy.edu.com',
                'username' => 'receptionisttb',
                'account_code' => 'ICY00004',
                'status' => 'active',
                'password' => bcrypt('12345'),
                'must_change_password' => 0,
                'first_login_at' => now(),
                'last_password_change_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Receptionist HCM',
                'email' => 'receptionisthcm@icy.edu.com',
                'username' => 'receptionisthcm',
                'account_code' => 'ICY00005',
                'status' => 'active',
                'password' => bcrypt('12345'),
                'must_change_password' => 0,
                'first_login_at' => now(),
                'last_password_change_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Teacher TB',
                'email' => 'teachertb@icy.edu.com',
                'username' => 'teachertb',
                'account_code' => 'ICY00006',
                'status' => 'active',
                'password' => bcrypt('12345'),
                'must_change_password' => 0,
                'first_login_at' => now(),
                'last_password_change_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Teacher HCM',
                'email' => 'teacherhcm@icy.edu.com',
                'username' => 'teacherhcm',
                'account_code' => 'ICY00007',
                'status' => 'active',
                'password' => bcrypt('12345'),
                'must_change_password' => 0,
                'first_login_at' => now(),
                'last_password_change_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Student TB',
                'email' => 'studenttb@icy.edu.com',
                'username' => 'studenttb',
                'account_code' => 'ICY00008',
                'status' => 'pending',
                'password' => bcrypt('12345'),
                'must_change_password' => 0,
                'first_login_at' => now(),
                'last_password_change_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Student HCM',
                'email' => 'studenthcm@icy.edu.com',
                'username' => 'studenthcm',
                'account_code' => 'ICY00009',
                'status' => 'pending',
                'password' => bcrypt('12345'),
                'must_change_password' => 0,
                'first_login_at' => now(),
                'last_password_change_at' => now(),
                'email_verified_at' => now(),
            ]            
        ];

        foreach ($users as $item){
            app(UserRepositoryInterface::class)->create($item);
        }

        $userDetails = [
            [
                'user_id' => 1,
                'phone' => '0868191110',
                'address' => 'Thường Tân',
                'avatar' => 'ICY00001-67ecb59fdfad6.png',
            ],
            [
                'user_id' => 2,
                'phone' => '',
                'address' => '',
                'avatar' => '',
            ],
            [
                'user_id' => 3,
                'phone' => '',
                'address' => '',
                'avatar' => '',
            ],
            [
                'user_id' => 4,
                'phone' => '',
                'address' => '',
                'avatar' => '',
            ],
            [
                'user_id' => 5,
                'phone' => '',
                'address' => '',
                'avatar' => '',
            ],
            [   
                'user_id' => 6,
                'phone' => '',
                'address' => '',
                'avatar' => '',
            ],
            [
                'user_id' => 7,
                'phone' => '',
                'address' => '',
                'avatar' => '',
            ],
            [   
                'user_id' => 8,
                'phone' => '',
                'address' => '',
                'avatar' => '',
            ],
            [
                'user_id' => 9,
                'phone' => '',
                'address' => '',
                'avatar' => '',
            ],
            [
                'user_id' => 10,
                'phone' => '',
                'address' => '',
                'avatar' => '',
            ],
        ];

        foreach ($userDetails as $item){
            UserDetail::updateOrCreate($item);
        }
    }
}
