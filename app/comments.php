<?php

namespace Bevy;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    public function comments(){
        return $this->hasOne(user::class,'user_id');
    }
}
