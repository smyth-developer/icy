<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'ordering',
        'location_id',
        'season_id',
        'subject_id',
        'name',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
