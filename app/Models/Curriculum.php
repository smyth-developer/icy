<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    protected $fillable = [
        'ordering',
        'program_id',
        'name',
    ];

    public function programs()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}
