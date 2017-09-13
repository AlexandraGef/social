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
            ->rightJoin('users','posts.user_id','users.id')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return view('home', compact('posts'));
    }

    public function addPost(Request $request) {
        $content = $request->content;
        $createPost = DB::table('posts')
            ->insert(['content' =>$content, 'user_id' =>Auth::user()->id,
                'status'=>0, 'created_at' =>date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s") ]);
        if($createPost){
            $posts_json = DB::table('users')
                ->rightJoin('profiles','profiles.user_id','users.id')
                ->rightJoin('posts','posts.user_id','users.id')
                ->orderBy('posts.created_at', 'desc')
                ->get();

            return $posts_json;
        }

    }
    public function deletePost($id)
    {
        $delete = DB::table('posts')->where('id',$id)->delete();
        if($delete){
            $posts_json = DB::table('users')
                ->rightJoin('profiles','profiles.user_id','users.id')
                ->rightJoin('posts','posts.user_id','users.id')
                ->orderBy('posts.created_at', 'desc')
                ->get();

            return $posts_json;
        }
    }


}
