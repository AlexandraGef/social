<?php

namespace Bevy;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    public function user()
    {
        return $this->hasOne(user::class, 'id', 'user_id');
    }
}
