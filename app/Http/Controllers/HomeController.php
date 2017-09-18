<?php

namespace Bevy\Http\Controllers;
use Bevy\posts;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = posts::with('user', 'likes', 'comments.user')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('home', compact('posts'));
    }
}
