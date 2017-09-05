<?php

namespace Bevy;

use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    protected $fillable = ['city','country','about','user_id'];

    public function profile()
    {
        return $this->hasOne('Bevy\profile');
    }
}
