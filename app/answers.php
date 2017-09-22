<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class answers extends Model
{
    public function user()
    {
        return $this->hasOne(user::class, 'id', 'user_id');
    }
}
