<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'bank_name' => 'VIB',
                'bank_code' => '970441',
                'account_number' => '866683539',
                'account_name' => 'CONG TY TNHH GIAO DUC VIEN SANG TAO',
                'status' => 'active',
                'description' => 'Bank account for the COMPANY',
            ],
            [
                'bank_name' => 'MBBANK',
                'bank_code' => '970422',
                'account_number' => '00866683593',
                'account_name' => 'NGUYEN THI THUY VY',
                'status' => 'active',
                'description' => 'Bank account for the PERSONNEL',
            ],
        ];

        foreach ($banks as $bank) {
            Bank::create($bank);
        }
    }
}
