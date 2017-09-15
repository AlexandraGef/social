<?php

namespace Bevy;

use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
  public function user(){
      return $this->belongsTo(user::class);
  }
    public function likes(){
        return $this->hasMany(likes::class);
    }
}
