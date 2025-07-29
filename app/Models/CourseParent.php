<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseParent extends Model
{
    protected $table = 'course_parent';

    protected $fillable = [
        'ordering',
        'name',
        'description',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'parent_id');
    }
}
