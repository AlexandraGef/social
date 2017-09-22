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

        DB::table('groupuser')
            ->insert(['user_id' => Auth::user()->id, 'group_id' =>  $group]);


        return redirect('/grupy')->with('msg', 'Twoja grupa została pomyślnie utworzona !');
    }
}
