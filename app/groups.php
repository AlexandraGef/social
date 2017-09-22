<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class groups extends Model
{
    public function user()
    {
        return $this->belongsToMany('App\User', 'groupuser',
            'group_id', 'user_id');
    }
    public function admins()
    {
        return $this->belongsToMany('App\User', 'groupadmins',
            'group_id', 'user_id');
    }
}
