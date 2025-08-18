<?php

namespace App\Support\Validation;

class SyllabusRules
{
    public static function rules($id = null): array
    {
        return [
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],
            'lesson_number' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'min:10', 'max:2000'],
            'objectives' => ['required', 'string', 'min:10', 'max:1000'],
            'vocabulary' => ['nullable', 'string', 'max:1000'],
            'assignment' => ['nullable', 'string', 'max:1000'],
            'student_task' => ['nullable', 'string', 'max:1000'],
            'lecturer_task' => ['nullable', 'string', 'max:1000'],
            'lecture_slide' => ['nullable', 'string', 'max:500'],
            'audio_file' => ['nullable', 'string', 'max:500'],
            'ordering' => ['required', 'integer', 'min:1'],
        ];
    }

    public static function messages(): array
    {
        return [
            'subject_id.required' => 'Môn học là bắt buộc.',
            'subject_id.integer' => 'Môn học không hợp lệ.',
            'subject_id.exists' => 'Môn học không tồn tại.',
            
            'lesson_number.required' => 'Số bài học là bắt buộc.',
            'lesson_number.max' => 'Số bài học không được vượt quá 255 ký tự.',
            
            'content.required' => 'Nội dung bài học là bắt buộc.',
            'content.min' => 'Nội dung bài học phải có ít nhất 10 ký tự.',
            'content.max' => 'Nội dung bài học không được vượt quá 2000 ký tự.',
            
            'objectives.required' => 'Mục tiêu bài học là bắt buộc.',
            'objectives.min' => 'Mục tiêu bài học phải có ít nhất 10 ký tự.',
            'objectives.max' => 'Mục tiêu bài học không được vượt quá 1000 ký tự.',
            
            'vocabulary.max' => 'Từ vựng không được vượt quá 1000 ký tự.',
            'assignment.max' => 'Bài tập không được vượt quá 1000 ký tự.',
            'student_task.max' => 'Nhiệm vụ học sinh không được vượt quá 1000 ký tự.',
            'lecturer_task.max' => 'Nhiệm vụ giảng viên không được vượt quá 1000 ký tự.',
            'lecture_slide.max' => 'Slide bài giảng không được vượt quá 500 ký tự.',
            'audio_file.max' => 'File âm thanh không được vượt quá 500 ký tự.',
            
            'ordering.required' => 'Thứ tự là bắt buộc.',
            'ordering.integer' => 'Thứ tự phải là số nguyên.',
            'ordering.min' => 'Thứ tự phải lớn hơn 0.',
        ];
    }

    public static function attributes(): array
    {
        return [
            'subject_id' => 'môn học',
            'lesson_number' => 'số bài học',
            'content' => 'nội dung',
            'objectives' => 'mục tiêu',
            'vocabulary' => 'từ vựng',
            'assignment' => 'bài tập',
            'student_task' => 'nhiệm vụ học sinh',
            'lecturer_task' => 'nhiệm vụ giảng viên',
            'lecture_slide' => 'slide bài giảng',
            'audio_file' => 'file âm thanh',
            'ordering' => 'thứ tự',
        ];
    }
}
