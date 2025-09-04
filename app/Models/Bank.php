<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bank_name',
        'bank_code',
        'account_number',
        'account_name',
        'status',
        'description',
    ];

    public function tuitions()
    {
        return $this->hasMany(Tuition::class);
    }
}
