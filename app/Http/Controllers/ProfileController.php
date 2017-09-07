<?php

namespace Bevy\Http\Controllers;

use Bevy\friendships;
use Illuminate\Http\Request;
use Auth;
use DB;
use Bevy\notifications;

class ProfileController extends Controller
{
    public function index($slug){
        $userData = DB::table('users')
            ->leftJoin('profiles','profiles.user_id','users.id')
            ->where('slug', $slug)
            ->get();

        return view('profile.index', compact('userData'));
    }
    public function getPic()
    {
        return view('profile.pic');
    }

    public function uploadPhoto(Request $request){

        $file = $request->file('pic');
        $filename = $file->getClientOriginalName();

        $path = 'img';

        $file->move($path, $filename);

        $user_id = Auth::user()->id;

        DB::table('users')->where('id', $user_id)->update(['pic'=>'http://localhost:8000/img/'.$filename]);

        return back()->with('msg','Zdjęcie zostało zmienione');
    }

    public function editProfileForm(){
        return view('profile.editProfile')->with('data',Auth::user()->profile);
    }

    public function updateProfile(Request $request)
    {
        $user_id = Auth::user()->id;
        DB::table('users')->leftJoin('profiles','users.id','=','profiles.user_id')->where('user_id','=', $user_id)->update($request->except('_token'));

        return back();
    }
    public function findFriends(){
        $uid = Auth::user()->id;
        $allUsers = DB::table('profiles')->leftJoin('users','users.id','=','profiles.user_id')->where('user_id','!=', $uid)->get();

       return view('profile.findFriends', compact('allUsers'));
    }

    public function sendRequest($id){
       Auth::user()->addFriend($id);

       return back();

    }

    public function requests(){
        $uid = Auth::user()->id;

        $FriendRequests = DB::table('friendships')
            ->rightJoin('users', 'users.id','=','friendships.requester')
            ->where('status', 0)
            ->where('friendships.user_requested', '=', $uid)->get();

       return view('profile.requests', compact('FriendRequests'));
    }

    public function accept($name,$id)
    {

        $uid = Auth::user()->id;
        $checkRequest = friendships::where('requester',$id)
            ->where('user_requested',$uid)
            ->first();
        if($checkRequest){
          $updateFriendship = DB::table('friendships')
               ->where('user_requested',$uid)
               ->where('requester',$id)
               ->update(['status' => 1]);

            $notifications = new notifications;
            $notifications->user_hero = $id;
            $notifications->note = ' zaakceptował/a Twoje zaprosznie';
            $notifications->user_logged = Auth::user()->id;
            $notifications->status = '1'; // nieodczytane powiadomienie
            $notifications->save();

    if($notifications)
              return back()->with('msg','Ty i '.$name.' zostaliście znajomymi !');

        }
    }

    public function friends()
    {
        $uid = Auth::user()->id;

        $friends1 = DB::table('friendships')
            ->leftJoin('users','users.id','friendships.user_requested')//wysylajacy zaproszenie
            ->where('status',1)
            ->where('requester',$uid) //zalogowany
            ->get();

        $friends2 = DB::table('friendships')
            ->leftJoin('users','users.id','friendships.requester')
            ->where('status',1)
            ->where('user_requested',$uid)
            ->get();

        $friends = array_merge($friends1->toArray(),$friends2->toArray());

        return view('profile.friends',compact('friends'));
    }

    public function requestRemove($id)
    {
      DB::table('friendships')
          ->where('user_requested',Auth::user()->id)
          ->where('requester',$id)
          ->delete();

      return back()->with('msg','Usunięto użytkownika ze znajomych');
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
            ->update(['status'=> 0]);

        return view('profile.notifications',compact('notes'));
    }
}
