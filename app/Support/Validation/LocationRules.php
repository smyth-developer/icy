<?php

namespace App\Support\Validation;

class LocationRules
{
    public static function rules($id = null): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:locations,name' . ($id ? ",$id" : ''),'regex:/^[\p{L}0-9\s]+$/u'],
            'address' => ['required', 'string', 'min:10'],
        ];
    }

    public static function messages(): array
    {
        return [
            'name.required' => 'Tên cơ sở là bắt buộc.',
            'name.min' => 'Tên cơ sở phải có ít nhất 3 ký tự.',
            'name.max' => 'Tên cơ sở không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên cơ sở này đã được sử dụng.',
            'name.regex' => 'Tên cơ sở chỉ không được chứa ký tự đặc biệt.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.min' => 'Địa chỉ phải có ít nhất 10 ký tự.',
        ];
    }
}
