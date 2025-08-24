<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'account_code',
        'password',
        'status',
        'login_attempts',
        'must_change_password',
        'last_password_change_at',
        'first_login_at',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_password_change_at' => 'datetime',
            'first_login_at' => 'datetime',
            'must_change_password' => 'boolean',
            'password' => 'hashed',
            'deleted_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * The attributes add information of user.
     */
    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    /**
     * The attributes add parent of user.
     */
    public function parent()
    {
        return $this->hasOne(UserParent::class);
    }

    /**
     * The attributes add location of user.
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'location_user');
    }

    /**
     * The attributes add role of user.
     */ 
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
}
