<?php

namespace App\Support\Validation;

class SubjectRules
{
    public static function rules($id = null): array
    {
        return [
            'program_id' => ['required', 'integer', 'exists:programs,id'],
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:subjects,name' . ($id ? ",$id" : ''),'regex:/^[\p{L}0-9\s]+$/u'],
            'code' => ['required', 'string', 'max:4', 'unique:subjects,code' . ($id ? ",$id" : ''), 'regex:/^[a-zA-Z0-9]+$/'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public static function messages(): array
    {
        return [
            'program_id.required' => 'Chương trình học là bắt buộc.',
            'program_id.integer' => 'Chương trình học không hợp lệ.',
            'program_id.exists' => 'Chương trình học không tồn tại.',
            'name.required' => 'Tên môn học là bắt buộc.',
            'name.min' => 'Tên môn học phải có ít nhất 3 ký tự.',
            'name.max' => 'Tên môn học không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên môn học này đã được sử dụng.',
            'name.regex' => 'Tên môn học chỉ không được chứa ký tự đặc biệt.',
            'code.required' => 'Mã môn học là bắt buộc.',
            'code.max' => 'Mã môn học không được vượt quá 4 ký tự.',
            'code.unique' => 'Mã môn học này đã được sử dụng.',
            'code.regex' => 'Mã môn học chỉ được chứa chữ và số.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',
        ];
    }
}
