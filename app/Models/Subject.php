<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'code', 'program_id', 'description', 'ordering'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function syllabi()
    {
        return $this->hasMany(Syllabus::class);
    }
}
