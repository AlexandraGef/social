<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Friendable;
use App\profile;

class User extends \TCG\Voyager\Models\User
{

    use Notifiable;
    use Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'role_id', 'password', 'slug', 'gender', 'pic',
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
        return $this->hasOne('App\profile');
    }

    public function roles()
    {
        return $this->hasOne('App\roles');
    }


}
