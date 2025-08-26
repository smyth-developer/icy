<?php

namespace App\Support\Validation;

class BankRules
{
    public static function rules(?int $id = null): array
    {
        return [
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:50', 'regex:/^[0-9]+$/'],
            'account_name' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\s]+$/u'],
            'status' => ['required', 'in:active,inactive'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public static function messages(): array
    {
        return [
            'bank_name.required' => 'Tên ngân hàng là bắt buộc.',
            'bank_name.string' => 'Tên ngân hàng phải là chuỗi.',
            'account_number.required' => 'Số tài khoản là bắt buộc.',
            'account_number.string' => 'Số tài khoản phải là chuỗi.',
            'account_number.regex' => 'Số tài khoản chỉ được chứa số.',
            'account_name.required' => 'Tên chủ tài khoản là bắt buộc.',
            'account_name.regex' => 'Tên chủ tài khoản chỉ được chứa chữ cái và khoảng trắng.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}


