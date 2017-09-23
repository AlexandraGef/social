<?php

namespace App\Http\Controllers;
use App\groups;
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
        $groups = Groups::with('user','admins')
            ->get();
        return $groups;
    }

    public function group($slug)
    {
        $groups = Groups::with('user','admins')
            ->where('slug', $slug)
            ->get();

        return view('group.index', compact('groups'));
    }

    protected function createGroup(Request $request)
    {
        $name = $request->name;
        $description = $request->description;

        DB::table('groups')
            ->insert(['name' => $name, 'description' => $description, 'pic' => 'http://localhost:8000/img/bevy.png','slug' => str_slug($name, '-'),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString()]);
        $group = DB::table('groups')->where('name', $name)->value('id');

        DB::table('groupadmins')
            ->insert(['user_id' => Auth::user()->id, 'group_id' =>  $group]);
        $user = DB::table('groupuser')
            ->insert(['user_id' => Auth::user()->id, 'group_id' =>  $group]);

        return redirect('/grupy')->with('msg', 'Twoja grupa została pomyślnie utworzona !');
    }

    public function joinToGroup($id) {
        $join = DB::table('groupuser')
            ->insert(['user_id' => Auth::user()->id, 'group_id' =>  $id]);

        DB::table('groups')->where('id', $id)->value('name');

        if($join){
            $groups = Groups::with('user','admins')
                ->get();
            return $groups;
        }

    }

    public function leaveGroup($id){
        $delete = DB::table('groupuser')->where('user_id', $id)->delete();
        if ($delete) {
            $groups = Groups::with('user','admins')
                ->get();
            return $groups;
        }

    }

    public function addNotiGroup(Request $request)
    {
        $text = $request->text;
        $id = $request->id;
        $uid = Auth::user()->id;

        $createNoti = DB::table('service')
            ->insert(['user_id' => $uid, 'group_id' => $id, 'excuse' => $text,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString()]);

        if ($createNoti) {
            return back()->with('msg', 'Dziękujemy za przesłanie zgłoszenia. Zapoznamy się z nim jak najszybciej !');
        }
    }

    public function deleteGroup($id){
        $delete = DB::table('groups')->where('id', $id)->delete();

        return redirect('/grupy')->with('msg', 'Twoja grupa została usunięta');

    }


}
