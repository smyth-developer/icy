<?php

namespace App\Support\Validation;

class SeasonRules
{
    public static function rules($id = null): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:seasons,name' . ($id ? ",$id" : ''), 'regex:/^[\p{L}0-9\s]+$/u'],
            'code' => ['required', 'string', 'min:2', 'max:10', 'unique:seasons,code' . ($id ? ",$id" : ''), 'regex:/^[A-Z0-9]+$/'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'note' => ['nullable', 'string', 'max:500'],
        ];
    }

    public static function messages(): array
    {
        return [
            'name.required' => 'Tên học kỳ là bắt buộc.',
            'name.min' => 'Tên học kỳ phải có ít nhất 3 ký tự.',
            'name.max' => 'Tên học kỳ không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên học kỳ này đã được sử dụng.',
            'name.regex' => 'Tên học kỳ chỉ không được chứa ký tự đặc biệt.',
            'code.required' => 'Mã học kỳ là bắt buộc.',
            'code.min' => 'Mã học kỳ phải có ít nhất 2 ký tự.',
            'code.max' => 'Mã học kỳ không được vượt quá 10 ký tự.',
            'code.unique' => 'Mã học kỳ này đã được sử dụng.',
            'code.regex' => 'Mã học kỳ chỉ được chứa chữ cái viết hoa và số.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
        ];
    }
}
