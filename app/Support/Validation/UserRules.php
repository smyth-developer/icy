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
            'password' => [
                $id ? 'nullable' : 'required', // Bắt buộc khi tạo mới, tùy chọn khi cập nhật
                'string',
                'min:8',
                'max:255',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/', // Ít nhất 1 chữ thường, 1 chữ hoa, 1 số, 1 ký tự đặc biệt
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
                'nullable',
                'string',
                'max:12',
                // Nếu cập nhật, bỏ qua bản ghi có user_id = $id
                'unique:user_details,id_card' . ($id ? ",$id,user_id" : ''),
                'regex:/^[0-9]+$/', // Chỉ cho phép số
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
            'avatarFile' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048', // Tối đa 2MB
            ],
        ];
    }

    /**
     * Định nghĩa các quy tắc xác thực khi cập nhật profile
     */
    public static function profileRules($id): array
    {
        return array_merge(
            [
                'name' => [
                    'required',
                    'string',
                    'min:2',
                    'max:255',
                    'regex:/^[\p{L}\s]+$/u',
                ],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users,email,' . $id,
                ],
            ],
            self::detailRules()
        );
    }

    /**
     * Định nghĩa các quy tắc xác thực khi đổi mật khẩu
     */
    public static function changePasswordRules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
                'current_password',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'different:current_password',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            ],
            'password_confirmation' => [
                'required',
                'same:password',
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
            
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 255 ký tự.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất 1 chữ thường, 1 chữ hoa, 1 số và 1 ký tự đặc biệt.',
            'password.different' => 'Mật khẩu mới phải khác mật khẩu hiện tại.',
            
            'current_password.required' => 'Mật khẩu hiện tại là bắt buộc.',
            'current_password.current_password' => 'Mật khẩu hiện tại không đúng.',
            
            // UserDetail validation messages
            'birthday.date' => 'Ngày sinh không đúng định dạng.',
            'birthday.before' => 'Ngày sinh phải trước ngày hôm nay.',
            'birthday.after' => 'Ngày sinh không hợp lệ.',
            
            'address.string' => 'Địa chỉ phải là chuỗi.',
            'address.max' => 'Địa chỉ không được vượt quá 500 ký tự.',
            
            'phone.regex' => 'Số điện thoại không đúng định dạng (VD: 0123456789 hoặc +84123456789).',
            
            'avatarFile.image' => 'Avatar phải là hình ảnh.',
            'avatarFile.mimes' => 'Avatar phải có định dạng: jpeg, png, jpg, gif.',
            'avatarFile.max' => 'Avatar không được vượt quá 2MB.',
        ];
    }
}
