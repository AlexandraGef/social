<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    protected $fillable = ['city', 'country', 'about', 'user_id'];

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }
}
