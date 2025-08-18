<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserParent extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'father_name',
        'father_phone',
        'mother_name',
        'mother_phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
