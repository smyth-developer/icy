<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'code', 'program_id', 'description', 'ordering'];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}
