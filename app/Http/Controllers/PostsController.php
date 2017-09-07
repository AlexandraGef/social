<?php

namespace Bevy\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PostsController extends Controller
{
    public function index()
    {
        $posts = DB::table('posts')
            ->leftJoin('users','users.id','posts.user_id')
            ->get();

        return view('home',compact('posts'));
    }
}
