<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

    const ADMIN_TYPE = 'admin';
    const OWNER_TYPE = 'owner';
    const DEFAULT_TYPE = 'member';

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'active', 'activation_token','type','phone','address', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activation_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()    {
        return $this->type === self::ADMIN_TYPE;
    }

    public function isOwner()    {
        return $this->type === self::OWNER_TYPE;
    }

    public function isMember()    {
        return $this->type === self::DEFAULT_TYPE;
    }

    public function group(){
        return $this->hasOne('App\GroupUser');
    }
}
