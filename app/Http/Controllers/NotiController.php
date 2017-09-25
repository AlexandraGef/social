<?php

namespace App\Http\Controllers;

use App\service;
use DB;

class NotiController extends Controller
{
    public function noti()
    {

        $service = service::with('profile.user', 'user', 'post.user', 'comment.user', 'answer.user', 'group')
            ->orderBy('created_at', 'DESC')
            ->get();
        return $service;

    }

    public function index()
    {

        return view('notifi.index');

    }

    public function deleteNoti($id)
    {
        $delete = DB::table('services')->where('id', $id)->delete();

        if ($delete) {
            $service = service::with('profile.user', 'user', 'post.user', 'comment.user', 'answer.user', 'group')
                ->orderBy('created_at', 'DESC')
                ->get();
            return $service;

        }
    }
}
