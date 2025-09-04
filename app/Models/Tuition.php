<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tuition extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'receipt_number',
        'program_id',
        'season_id',
        'price',
        'status',
        'payment_method',
        'bank_id',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
