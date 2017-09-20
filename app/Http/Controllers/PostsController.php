<?php

namespace Bevy\Http\Controllers;

use Auth;
use Bevy\posts;
use DB;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    public function addPost(Request $request)
    {
        $content = $request->content;
        $createPost = DB::table('posts')
            ->insert(['content' => $content, 'user_id' => Auth::user()->id,
                'status' => 0, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")]);
        if ($createPost) {
            return posts::with('user', 'likes', 'comments.user')
                ->orderBy('created_at', 'DESC')
                ->get();
        }

    }

    public function editPost(Request $request)
    {
        $editContent = $request->editContent;
        $id = $request->id;
        $editPost = DB::table('posts')
            ->where('id', $id)
            ->update(['content' => $editContent]);
        if ($editPost) {
            return posts::with('user', 'likes', 'comments.user')
                ->orderBy('created_at', 'DESC')
                ->get();
        }
    }

    public function findPosts()
    {
        $posts = posts::with('user', 'likes', 'comments.user')
            ->orderBy('created_at', 'DESC')
            ->get();
        return $posts;
    }

    public function deletePost($id)
    {
        $delete = DB::table('posts')->where('id', $id)->delete();
        if ($delete) {
            return posts::with('user', 'likes', 'comments.user')
                ->orderBy('created_at', 'DESC')
                ->get();
        }
    }

    public function likePost($id)
    {
        $likePost = DB::table('likes')->insert([
            'posts_id' => $id,
            'user_id' => Auth::user()->id,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        if ($likePost) {
            return posts::with('user', 'likes', 'comments.user')
                ->orderBy('created_at', 'DESC')
                ->get();
        }

    }

    public function unlikePost($id)
    {
        $delete = DB::table('likes')->where('id', $id)->delete();
        if ($delete) {
            return posts::with('user', 'likes', 'comments.user')
                ->orderBy('created_at', 'DESC')
                ->get();
        }
    }

    public function addComment(Request $request)
    {
        $comment = $request->comment;
        $id = $request->id;

        $createComment = DB::table('comments')
            ->insert(['comment' => $comment, 'user_id' => Auth::user()->id, 'posts_id' => $id,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString()]);

        if ($createComment) {
            return posts::with('user', 'likes', 'comments.user')
                ->orderBy('created_at', 'DESC')
                ->get();
        }
    }


    public function deleteComment($id)
    {
        $delete = DB::table('comments')->where('id', $id)->delete();
        if ($delete) {
            return posts::with('user', 'likes', 'comments.user')
                ->orderBy('created_at', 'DESC')
                ->get();
        }
    }

    public function addNotiPost(Request $request)
    {
        $text = $request->text;
        $id = $request->id;
        $uid = Auth::user()->id;

        $createNoti = DB::table('service')
            ->insert(['user_id' => $uid, 'post_id' => $id, 'excuse' => $text,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString()]);

        if ($createNoti) {
            return back()->with('msg', 'Dziękujemy za przesłanie zgłoszenia. Zapoznamy się z nim jak najszybciej !');
        }
    }

    public function addNotiCom(Request $request)
    {
        $text = $request->text;
        $id = $request->id;
        $uid = Auth::user()->id;

        $createNoti = DB::table('service')
            ->insert(['user_id' => $uid, 'comment_id' => $id, 'excuse' => $text,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString()]);

        if ($createNoti) {
            return back()->with('msg', 'Dziękujemy za przesłanie zgłoszenia. Zapoznamy się z nim jak najszybciej !');
        }
    }

    public function addNotiProfile(Request $request)
    {
        $text = $request->text;
        $id = $request->id;
        $uid = Auth::user()->id;

        $createNoti = DB::table('service')
            ->insert(['user_id' => $uid, 'profile_id' => $id, 'excuse' => $text,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString()]);

        if ($createNoti) {
            return back()->with('msg', 'Dziękujemy za przesłanie zgłoszenia. Zapoznamy się z nim jak najszybciej !');
        }
    }


}
