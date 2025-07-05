<?php

namespace App\Support\Validation;

class RoleRules
{
    /**
     * Định nghĩa các quy tắc xác thực cho Role
     */
    public static function rules($id = null): array
    {
        return [
            'name' => [
                'required',  // Tên vai trò là bắt buộc
                'string',    // Phải là chuỗi
                'min:3',     // Tối thiểu 3 ký tự
                'max:255',   // Tối đa 255 ký tự
                'unique:roles,name' . ($id ? ",$id" : ''),  // Kiểm tra tính duy nhất trong bảng 'roles'
                'regex:/^[\p{L}0-9\s]+$/u',  // Không có ký tự đặc biệt, chỉ cho phép chữ cái, số và khoảng trắng
            ],
            'description' => [
                'required',  // Mô tả có thể để trống
                'string',    // Phải là chuỗi
                'max:500',   // Mô tả tối đa 500 ký tự
            ],
        ];
    }

    /**
     * Định nghĩa các thông báo lỗi tùy chỉnh cho Role
     */
    public static function messages(): array
    {
        return [
            'name.required' => 'Tên vai trò là bắt buộc.',
            'name.min' => 'Tên vai trò phải có ít nhất 3 ký tự.',
            'name.max' => 'Tên vai trò không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên vai trò này đã tồn tại.',
            'name.regex' => 'Tên vai trò chỉ được chứa chữ cái, số và khoảng trắng.',
            'description.required' => 'Mô tả là bắt buộc.',
            'description.string' => 'Mô tả phải là chuỗi.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',
        ];
    }
}
