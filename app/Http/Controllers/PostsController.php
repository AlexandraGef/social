<?php

namespace Bevy\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class PostsController extends Controller
{
    public function index()
    {
        $posts = DB::table('posts')
            ->leftJoin('users','users.id','posts.user_id')
            ->get();

        return view('home',compact('posts'));
    }

    public function addPost(Request $request) {
        $content = $request->content;
        $createPost = DB::table('posts')
            ->insert(['content' =>$content, 'user_id' =>Auth::user()->id,
                'status'=>0, 'created_at' =>date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s") ]);
    }
}
