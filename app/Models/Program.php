<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['name', 'english_name' , 'description', 'ordering'];

    public function curricula()
    {
        return $this->hasMany(Curriculum::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
