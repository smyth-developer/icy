<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'ordering',
    ];

    public function parent()
    {
        return $this->belongsTo(CourseParent::class, 'parent_id');
    }
}
