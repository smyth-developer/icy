<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'router',
        'displayName',
        'isShow',
    ];

    protected $casts = [
        'isShow' => 'boolean',
    ];

    /**
     * Get the roles associated with the permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}
