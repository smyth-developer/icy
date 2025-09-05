<?php

namespace App\Support\Validation;

class UserRules
{
    /**
     * Định nghĩa các quy tắc xác thực cho User
     */
    public static function rules($id = null): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[\p{L}\s]+$/u', // Chỉ cho phép chữ cái và khoảng trắng
            ],
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                'unique:users,email' . ($id ? ",$id" : ''),
            ],
        ];
    }

    /**
     * Định nghĩa các quy tắc xác thực cho UserDetail
     */
    public static function detailRules($id = null): array
    {
        return [
            'birthday' => [
                'nullable',
                'date',
                'before_or_equal:' . now()->format('Y-m-d'),
                'after:1960-01-01',
            ],
            'id_card' => [
                'regex:/^(?!0{12})(?!.*(\d)\1{11})\d{12}$/',
                'unique:user_details,id_card' . ($id ? ",$id,user_id" : ''),
            ],
            'address' => [
                'nullable',
                'string',
                'max:500',
            ],
            'phone' => [
                'nullable',
                'string',
                'regex:/^(\+84|0)[0-9]{9,10}$/', // Định dạng số điện thoại Việt Nam
            ],
            'gender' => [
                'nullable',
                'boolean',
            ],
            'guardian_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'guardian_phone' => [
                'nullable',
                'string',
                'regex:/^(\+84|0)[0-9]{9,10}$/',
            ],
            'avatarFile' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048', // Tối đa 2MB
            ],
        ];
    }

    /**
     * Định nghĩa các thông báo lỗi tùy chỉnh cho User
     */
    public static function messages(): array
    {
        return [
            // User validation messages
            'name.required' => 'Họ và tên là bắt buộc.',
            'name.min' => 'Họ và tên phải có ít nhất 2 ký tự.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'name.regex' => 'Họ và tên chỉ được chứa chữ cái và khoảng trắng.',

            'email.email' => 'Email không đúng định dạng.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'email.unique' => 'Email này đã được sử dụng.',

            // UserDetail validation messages
            'birthday.date' => 'Ngày sinh không đúng định dạng.',
            'birthday.before' => 'Ngày sinh phải trước ngày hôm nay.',
            'birthday.after' => 'Ngày sinh không hợp lệ.',

            'id_card.unique' => 'CCCD này đã được sử dụng.',
            'id_card.regex' => 'CCCD không hợp lệ.',

            'address.string' => 'Địa chỉ phải là chuỗi.',
            'address.max' => 'Địa chỉ không được vượt quá 500 ký tự.',

            'phone.regex' => 'Số điện thoại không đúng định dạng (VD: 0123456789 hoặc +84123456789).',

            'guardian_name.max' => 'Họ và tên người giám hộ không được vượt quá 255 ký tự.',

            'guardian_phone.regex' => 'Số điện thoại người giám hộ không đúng định dạng (VD: 0123456789 hoặc +84123456789).',

            'avatarFile.image' => 'Avatar phải là hình ảnh.',
            'avatarFile.mimes' => 'Avatar phải có định dạng: jpeg, png, jpg, gif.',
            'avatarFile.max' => 'Avatar không được vượt quá 2MB.',
        ];
    }
}
