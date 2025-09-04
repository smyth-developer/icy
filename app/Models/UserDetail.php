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
        'id_card',
        'address',
        'phone',
        'avatar',
        'gender',
        'guardian_name',
        'guardian_phone',
    ];

    public function getBirthdayAttribute($value)
    {
        return $value ? Carbon::parse($value)->setTimezone(config('app.timezone'))->format('Y-m-d') : '';
    }

    public function gender($value)
    {
        return $value ? 'Nữ' : 'Nam';
    }

    protected $casts = [
        'birthday' => 'date',
        'gender' => 'boolean',
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
