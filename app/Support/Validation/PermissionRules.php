<?php

namespace App\Support\Validation;

class PermissionRules
{
    public static function rules($id = null): array
    {
        return [
            'router' => ['required', 'string', 'max:255', 'unique:permissions,router' . ($id ? ",$id" : '')],
            'displayName' => ['required', 'string', 'max:255'],
        ];
    }

    public static function messages(): array
    {
        return [
            'router.required' => 'Vui lòng chọn route.',
            'router.unique' => 'Route này đã có permission.',
            'displayName.required' => 'Vui lòng nhập tên hiển thị.',
            'displayName.max' => 'Tên hiển thị không được vượt quá 255 ký tự.',
        ];
    }
}