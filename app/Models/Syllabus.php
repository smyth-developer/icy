<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    protected $table = 'syllabi';
    protected $fillable = [
        'ordering',
        'subject_id',
        'lesson_number',
        'content',
        'objectives',
        'vocabulary',
        'assignment',
        'student_task',
        'lecturer_task',
        'lecture_slide',
        'audio_file'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
