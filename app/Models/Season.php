<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'name',
        'code',
        'start_date',
        'end_date',
        'status',
        'note',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function getFormattedStartDateAttribute(): string
    {
        return optional($this->start_date)->format('Y-m-d');
    }

    public function getFormattedEndDateAttribute(): string
    {
        return optional($this->end_date)->format('Y-m-d');
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->season_status) {
            'upcoming' => 'yellow',
            'ongoing'  => 'green',
            'finished' => 'red',
            default    => 'gray',
        };
    }

    public function getStatusBadgeLabelAttribute(): string
    {
        return match ($this->season_status) {
            'upcoming' => 'Sắp diễn ra',
            'ongoing'  => 'Đang diễn ra',
            'finished' => 'Đã kết thúc',
            default    => 'Không rõ',
        };
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
