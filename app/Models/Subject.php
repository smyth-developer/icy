<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'code', 'program_id', 'description', 'ordering', 'price'];

    public function getPriceAttribute($value)
    {
        return number_format($value, 0, ',', '.') . ' VNĐ';
    }

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
