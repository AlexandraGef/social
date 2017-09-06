<?php

namespace Bevy;

use Illuminate\Database\Eloquent\Model;

class friendships extends Model
{
  protected $fillable = ['requester','user_requested','status'];
}
