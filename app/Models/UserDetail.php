<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'birthday',
        'address',
        'phone',
        'avatar',
    ];

    public function getBirthdayAttribute($value)
    {
        return $value ? Carbon::parse($value)->setTimezone(config('app.timezone'))->format('Y-m-d') : '';
    }

    protected $casts = [
        'birthday' => 'date',
    ];

    public function getAvatarAttribute($value)
    {
        return $value
            ? asset('storage/images/avatars/' . $value) // file upload bởi user
            : asset('storage/images/avatars/default-avatar.png'); // file mặc định nằm ở public/images/avatars/
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
