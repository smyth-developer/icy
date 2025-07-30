<?php

namespace App\Support\Validation;

class ProgramRules
{
    public static function rules($id = null): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:programs,name' . ($id ? ",$id" : ''),'regex:/^[\p{L}0-9\s]+$/u'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public static function messages(): array
    {
        return [
            'name.required' => 'Tên chương trình học là bắt buộc.',
            'name.min' => 'Tên chương trình học phải có ít nhất 3 ký tự.',
            'name.max' => 'Tên chương trình học không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên chương trình học này đã được sử dụng.',
            'name.regex' => 'Tên chương trình học chỉ không được chứa ký tự đặc biệt.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',
        ];
    }
}
