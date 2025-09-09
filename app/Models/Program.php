<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Program extends Model
{
    protected $fillable = ['name', 'english_name' , 'description', 'ordering'];
    
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function tuitions()
    {
        return $this->hasMany(Tuition::class);
    }

    public function programLocationPrices()
    {
        return $this->hasMany(ProgramLocationPrice::class);
    }
}
