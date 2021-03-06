<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    public function user()
    {
        return $this->hasOne(user::class, 'id', 'user_id');
    }
    public function answers()
    {
        return $this->hasMany(answers::class, 'comment_id');
    }
}
