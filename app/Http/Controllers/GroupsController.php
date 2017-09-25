<?php

namespace App\Http\Controllers;

use App\groups;
use App\notifications;
use App\posts;
use Auth;
use DB;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function index()
    {
        return view('group.findGroups');
    }

    public function groups()
    {
        $groups = Groups::with('user', 'admins')
            ->get();
        return $groups;
    }

    public function group($slug)
    {
        $groups = Groups::with('user', 'admins')
            ->where('slug', $slug)
            ->get();

        return view('group.index', compact('groups'));
    }

    public function joinToGroup($id)
    {
        $join = DB::table('groupuser')
            ->insert(['user_id' => Auth::user()->id, 'group_id' => $id]);

        DB::table('groups')->where('id', $id)->value('name');

        if ($join) {
            $groups = Groups::with('user', 'admins')
                ->get();
            return $groups;
        }

    }

    public function leaveGroup($id)
    {
        $delete = DB::table('groupuser')->where('user_id', $id)->delete();
        if ($delete) {
            $groups = Groups::with('user', 'admins')
                ->get();
            return $groups;
        }

    }

    public function addNotiGroup(Request $request)
    {
        $text = $request->text;
        $id = $request->id;
        $uid = Auth::user()->id;

        $createNoti = DB::table('services')
            ->insert(['user_id' => $uid, 'group_id' => $id, 'excuse' => $text,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString()]);

        $query = DB::table('users')->where('role_id', 4)->get();
        foreach ($query as $q) {
            $idd = $q->id;
            $moderators[] = $idd;
        }
        $name = DB::table('groups')->where('id', $id)->value('name');
        foreach ($moderators as $mod) {

            $notifications = new notifications;
            $notifications->user_hero = $mod;
            $notifications->note = 'Zgłoszenie grupy: '.$name.', treść: ' . $text;
            $notifications->user_logged = Auth::user()->id;
            $notifications->status = '1'; // nieodczytane powiadomienie
            $notifications->save();
        }
        if ($notifications)
            return back()->with('msg', 'Dziękujemy za przesłanie zgłoszenia. Zapoznamy się z nim jak najszybciej !');

    }

    public function deleteGroup($id)
    {
        $delete = DB::table('groups')->where('id', $id)->delete();
        DB::table('services')->where('group_id',$id)->delete();

        return redirect('/grupy')->with('msg', 'Twoja grupa została usunięta');

    }

    public function editGroupForm($id)
    {
        $groups = DB::table('groups')->where('id', $id)->get();

        return view('group.editGroup', compact('groups'));
    }

    public function updateGroup(Request $request)
    {
        $id = $request->id;
        DB::table('groups')->where('id', '=', $id)->update($request->except('_token'));

        return back()->with('msg', 'Informacje o grupie zostały zaktualizowane.');
    }

    public function editGroupAv($id)
    {
        $groups = DB::table('groups')->where('id', $id)->get();

        return view('group.pic', compact('groups'));
    }

    public function uploadAvatar(Request $request)
    {

        $file = $request->file('pic');
        $filename = $file->getClientOriginalName();

        $path = 'img';

        $file->move($path, $filename);

        $id = $request->id;

        DB::table('groups')->where('id', $id)->update(['pic' => 'http://localhost:8000/img/' . $filename]);

        return back()->with('msg', 'Avatar został zmieniony');
    }

    public function addGroupPost(Request $request)
    {
        $content = $request->content;
        $id = $request->id;

        $createPost = DB::table('posts')
            ->insert(['content' => $content, 'user_id' => Auth::user()->id,
                'status' => 0, 'group_id' => $id, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")]);
        if ($createPost) {
            return posts::with('user', 'likes', 'comments.user', 'comments.answers.user')
                ->orderBy('created_at', 'DESC')
                ->get();
        }
    }

    public function groupMembers($slug)
    {

        $id = DB::table('groups')->where('slug', $slug)->value('id');

        $groupMembers = DB::table('groupuser')->where('group_id', $id)->get();

        foreach ($groupMembers as $user) {

            if ($us = DB::table('users')->where('id', $user->user_id)->get()) {

                $members[] = $us;
            }

        }

        return view('group.groupMembers', compact('members'));
    }

    public function countGroupMembers($id)
    {
        $groupMembers = DB::table('groupuser')->where('group_id', $id)->get();
        $countMembers = count($groupMembers);

        return $countMembers;
    }

    protected function createGroup(Request $request)
    {
        $name = $request->name;
        $description = $request->description;
        $rand = rand(0, 10000);
        $new = DB::table('groups')
            ->insertGetId(['name' => $name, 'description' => $description, 'pic' => 'http://localhost:8000/img/bevy.png', 'slug' => str_slug($name, '-') . $rand,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString()]);

        DB::table('groupadmins')
            ->insert(['user_id' => Auth::user()->id, 'group_id' => $new]);
        $user = DB::table('groupuser')
            ->insert(['user_id' => Auth::user()->id, 'group_id' => $new]);

        return redirect('/grupy')->with('msg', 'Twoja grupa została pomyślnie utworzona !');
    }

}
