<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProgramLocationPrice extends Model
{
    protected $table = 'program_location_prices';

    protected $fillable = ['program_id', 'location_id', 'price'];

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (float) $value,
            set: fn ($value) => (float) str_replace(['.', ',', ' VNĐ'], '', $value)
        );
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
