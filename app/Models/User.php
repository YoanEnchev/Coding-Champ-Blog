<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Propaganistas\LaravelFakeId\RoutesWithFakeIds;

class User extends Authenticatable
{
    use Notifiable;
    use RoutesWithFakeIds;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    // Needed for access to the fake ID.
    public function getFakeIdAttribute()
    {
        return $this->getRouteKey();
    }

    public function isAdmin() {
        return $this->is_admin;
    }
}
