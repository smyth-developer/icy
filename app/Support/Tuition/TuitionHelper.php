<?php

namespace App\Support\Tuition;

use App\Support\Bank\BankHelper;
use App\Repositories\Contracts\BankRepositoryInterface;

class TuitionHelper
{
    public static function generateInformationTransaction(object $transaction)
    {
        $bank_code = app(BankRepositoryInterface::class)->getById($transaction->bank_id)->bank_code;
        $bank_number = app(BankRepositoryInterface::class)->getById($transaction->bank_id)->account_number;
        $amount = $transaction->price;

        $description = $transaction->note;

        return BankHelper::buildVietQR($bank_code, $bank_number, $amount, $description);
    }
}