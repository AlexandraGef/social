<?php

namespace App\Http\Controllers;

use App\service;
use DB;
use Auth;
use App\notifications;

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

    public function deleteNotifications($id)
    {
        $delete = DB::table('notifications')->where('id', $id)->delete();
         if($delete)
        return back()->with('msg','Powiadomienie zostało usunięte.');
    }


    public function notifications($id)
    {
        $uid = Auth::user()->id;
        $notes = DB::table('notifications')
            ->leftJoin('users', 'users.id', 'notifications.user_logged')
            ->where('notifications.id', $id)
            ->where('user_hero', $uid)
            ->orderBy('notifications.created_at', 'desc')
            ->get();

        $updateNote = DB::table('notifications')
            ->where('notifications.id', $id)
            ->update(['status' => 0]);

        return view('profile.notifications', compact('notes',$notes,'id',$id));
    }
}
