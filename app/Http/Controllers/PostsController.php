<?php

namespace Bevy\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Bevy\posts;
class PostsController extends Controller
{

    public function addPost(Request $request) {
        $content = $request->content;
        $createPost = DB::table('posts')
            ->insert(['content' =>$content, 'user_id' =>Auth::user()->id,
                'status'=>0, 'created_at' =>date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s") ]);
        if($createPost){
  return posts::with('user','likes')
      ->orderBy('created_at','DESC')
      ->get();
        }

    }
    public function deletePost($id)
    {
        $delete = DB::table('posts')->where('id',$id)->delete();
        if($delete){
   return posts::with('user','likes')
       ->orderBy('created_at','DESC')
       ->get();
        }
    }
    public function likePost($id) {
        $likePost = DB::table('likes')->insert([
            'posts_id' => $id,
            'user_id' => Auth::user()->id,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        if($likePost){
            return posts::with('user','likes')
                ->orderBy('created_at','DESC')
                ->get();
        }

    }


}
