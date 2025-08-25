<?php

namespace App\Support\User;

use App\Models\User;
use Illuminate\Support\Str;

class UserHelper
{
    public static function randomUsername(string $name): string
    {
        $student_name = ucwords(trim($name));

        $parts = explode(' ', strtolower(Str::of($student_name)->ascii()->slug(' ')));
        $username = '';
        foreach ($parts as $index => $part) {
            if ($index === count($parts) - 1) {
                $username = $part . $username;
            } else {
                $username .= $part[0];
            }
        } //lấy tên đầu tiên của từng từ trong họ và tên

        $counter = 1;
        $originalUsername = $username;

        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        } //nếu tên đăng nhập đã tồn tại thì thêm số vào cuối

        return $username;
    }

    public static function randomAccountCode(): string
    {
        $number = User::lockForUpdate()->count() + 1;

        do {
            $account_code = "ICY" . str_pad($number, 5, '0', STR_PAD_LEFT);
            $number++; // Nếu trùng, tăng thêm 1
        } while (User::where('account_code', $account_code)->exists());
        return $account_code;
    }

    public static function randomPassword($length = 10)
    {
        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $special = '!@#$%^&*()_+-=[]{}|;:,.<>?';

        $password =
            $upper[random_int(0, strlen($upper) - 1)] .
            $lower[random_int(0, strlen($lower) - 1)] .
            $numbers[random_int(0, strlen($numbers) - 1)] .
            $special[random_int(0, strlen($special) - 1)];

        $all = $upper . $lower . $numbers . $special;
        for ($i = strlen($password); $i < $length; $i++) {
            $password .= $all[random_int(0, strlen($all) - 1)];
        }

        return str_shuffle($password);
    }
}
