<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\profile;
use App\groups;
use App\User;
use App\comments;
use App\answers;
use App\posts;

class service extends Model
{
    public function profile()
    {
        return $this->hasOne('App\profile','id','profile_id');
    }

    public function user()
    {
        return $this->hasOne('App\user','id','user_id');
    }
    public function post()
    {
        return $this->hasOne('App\posts','id','post_id');
    }
    public function comment()
    {
        return $this->hasOne('App\comments','id','comment_id');
    }
    public function answer()
    {
        return $this->hasOne('App\answers','id','answer_id');
    }
    public function group()
    {
        return $this->hasOne('App\groups','id','group_id');
    }
}
