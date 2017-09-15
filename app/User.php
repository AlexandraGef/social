<?php

namespace Bevy;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Bevy\Traits\Friendable;
use Bevy\profile;

class User extends Authenticatable
{

    use Notifiable;
    use Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','password','slug','gender','pic',
    ];
 public function isRole()
 {
 return $this->role;
 }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne('Bevy\profile');
    }
    public function comments(){
        return $this->hasMany(comments::class);
    }
}
