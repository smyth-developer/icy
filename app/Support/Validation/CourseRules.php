<?php

namespace App\Support\Validation;

class CourseRules
{
    public static function rules(?int $id = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'location_id' => ['required', 'exists:locations,id'],
            'season_id' => ['required', 'exists:seasons,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public static function messages(): array
    {
        return [
            'name.required' => 'Tên lớp học là bắt buộc.',
            'location_id.required' => 'Cơ sở học là bắt buộc.',
            'season_id.required' => 'Mùa là bắt buộc.',
            'subject_id.required' => 'Môn học là bắt buộc.',
            'ordering.required' => 'Thứ tự là bắt buộc.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',
        ];
    }
}