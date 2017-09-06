<?php

namespace Bevy\Traits;

use Bevy\friendships;

trait Friendable
{
    public function addFriend($id){

        $Friendship = friendships::create([
            'requester' => $this->id,
            'user_requested' =>$id,
            'status' => 0,
        ]);
       if($Friendship)
       {
           return $Friendship;
       }

       return 'falied';
    }
}