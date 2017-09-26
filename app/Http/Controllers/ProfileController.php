<?php

namespace App\Http\Controllers;

use App\friendships;
use App\notifications;
use Auth;
use DB;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($slug)
    {
        $userData = DB::table('users')
            ->leftJoin('profiles', 'profiles.user_id', 'users.id')
            ->where('slug', $slug)
            ->get();

        return view('profile.index', compact('userData'));
    }

    public function getPic()
    {
        return view('profile.pic');
    }

    public function uploadPhoto(Request $request)
    {

        $file = $request->file('pic');
        $filename = $file->getClientOriginalName();

        $path = 'img';

        $file->move($path, $filename);

        $user_id = Auth::user()->id;

        DB::table('users')->where('id', $user_id)->update(['pic' => 'http://localhost:8000/img/' . $filename]);

        return back()->with('msg', 'Zdjęcie zostało zmienione');
    }

    public function editProfileForm()
    {
        return view('profile.editProfile')->with('data', Auth::user()->profile);
    }

    public function updateProfile(Request $request)
    {
        $user_id = Auth::user()->id;
        DB::table('users')->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')->where('user_id', '=', $user_id)->update($request->except('_token'));

        return back();
    }

    public function checkFriends()
    {
        $uid = Auth::user()->id;

        $friends1 = DB::table('friendships')
            ->leftJoin('users', 'users.id', 'friendships.user_requested')//wysylajacy zaproszenie
            ->where('status', 1)
            ->where('requester', $uid)//zalogowany
            ->get();

        $friends2 = DB::table('friendships')
            ->leftJoin('users', 'users.id', 'friendships.requester')
            ->where('status', 1)
            ->where('user_requested', $uid)
            ->get();

        $friends = array_merge($friends1->toArray(), $friends2->toArray());

        return $friends;

    }

    public function findFriends()
    {
        $uid = Auth::user()->id;
        $allUsers = DB::table('profiles')
            ->leftJoin('users', 'users.id', '=', 'profiles.user_id')
            ->where('user_id', '!=', $uid)->get();

        foreach ($allUsers as $user) {
            $check = DB::table('friendships')
                ->where('user_requested', '=', $user->id)
                ->where('requester', '=', $uid)
                ->first();
        }

        return view('profile.findFriends', compact('check'));
    }

    public function sendReq()
    {
        $uid = Auth::user()->id;
        $allUsers = DB::table('profiles')
            ->leftJoin('users', 'users.id', '=', 'profiles.user_id')
            ->where('user_id', '!=', $uid)->get();

        foreach ($allUsers as $user) {
            $check = DB::table('friendships')
                ->where('requester', $uid)
                ->orWhere('user_requested', $uid)
                ->get();
        }
        return $check;
    }

    public function sendRequest($id)
    {
        Auth::user()->addFriend($id);
        $loggedUser = Auth::user()->id;
        $allUsers = DB::table('profiles')
            ->leftJoin('users', 'users.id', '=', 'profiles.user_id')
            ->where('user_id', '!=', $loggedUser)->get();

        foreach ($allUsers as $user) {
            $check = DB::table('friendships')
                ->where('requester', $loggedUser)
                ->orWhere('user_requested', $loggedUser)
                ->get();
        }
        return $check;

    }

    public function requests()
    {
        $uid = Auth::user()->id;

        $FriendRequests = DB::table('friendships')
            ->rightJoin('users', 'users.id', '=', 'friendships.requester')
            ->where('status', 0)
            ->where('friendships.user_requested', '=', $uid)->get();

        return view('profile.requests', compact('FriendRequests'));
    }

    public function accept($name, $id)
    {

        $uid = Auth::user()->id;
        $checkRequest = friendships::where('requester', $id)
            ->where('user_requested', $uid)
            ->first();
        if ($checkRequest) {
            $updateFriendship = DB::table('friendships')
                ->where('user_requested', $uid)
                ->where('requester', $id)
                ->update(['status' => 1]);

            $notifications = new notifications;
            $notifications->user_hero = $id;
            $notifications->note = ' zaakceptował/a Twoje zaprosznie';
            $notifications->user_logged = Auth::user()->id;
            $notifications->status = '1'; // nieodczytane powiadomienie
            $notifications->save();

            if ($notifications)
                return back()->with('msg', 'Ty i ' . $name . ' zostaliście znajomymi !');

        }
    }

    public function friends()
    {
        $uid = Auth::user()->id;

        $friends1 = DB::table('friendships')
            ->leftJoin('users', 'users.id', 'friendships.user_requested')//wysylajacy zaproszenie
            ->where('status', 1)
            ->where('requester', $uid)//zalogowany
            ->get();

        $friends2 = DB::table('friendships')
            ->leftJoin('users', 'users.id', 'friendships.requester')
            ->where('status', 1)
            ->where('user_requested', $uid)
            ->get();

        $friends = array_merge($friends1->toArray(), $friends2->toArray());

        return view('profile.friends', compact('friends'));
    }

    public function requestRemove($id)
    {
        DB::table('friendships')
            ->where('user_requested', Auth::user()->id)
            ->where('requester', $id)
            ->delete();

        return back()->with('msg', 'Odrzucono zaproszenie');
    }


    public function friendRemove($id)
    {
        $loggedUser = Auth::user()->id;

        DB::table('friendships')
            ->where('requester', $loggedUser)
            ->where('user_requested', $id)
            ->delete();

      DB::table('friendships')
            ->where('requester', $id)
            ->where('user_requested', $loggedUser)
            ->delete();

        $allUsers = DB::table('profiles')
            ->leftJoin('users', 'users.id', '=', 'profiles.user_id')
            ->where('user_id', '!=', $loggedUser)->get();

        foreach ($allUsers as $user) {
            $check = DB::table('friendships')
                ->where('requester', $loggedUser)
                ->orWhere('user_requested', $loggedUser)
                ->get();
        }
        return $check;
    }

    public function sendMessage(Request $request)
    {
        $conID = $request->conID;
        $msg = $request->msg;
        $checkUserId = DB::table('messages')->where('conversation_id', $conID)->get();
        if ($checkUserId[0]->user_from == Auth::user()->id) {
            // fetch user_to
            $fetch_userTo = DB::table('messages')->where('conversation_id', $conID)
                ->get();
            $userTo = $fetch_userTo[0]->user_to;
        } else {
            // fetch user_to
            $fetch_userTo = DB::table('messages')->where('conversation_id', $conID)
                ->get();
            $userTo = $fetch_userTo[0]->user_to;
        }
        // now send message
        $sendM = DB::table('messages')->insert([
            'user_to' => $userTo,
            'user_from' => Auth::user()->id,
            'msg' => $msg,
            'status' => 1,
            'conversation_id' => $conID
        ]);
        if ($sendM) {
            $userMsg = DB::table('messages')
                ->join('users', 'users.id', 'messages.user_from')
                ->where('messages.conversation_id', $conID)->get();
            return $userMsg;
        }

    }

    public function findUsers()
    {
        $allUsers = DB::table('profiles')
            ->leftJoin('users', 'users.id', '=', 'profiles.user_id')
            ->where('user_id', '!=', Auth::user()->id)->get();

        return $allUsers;
    }

    public function newMessage()
    {
        $uid = Auth::user()->id;
        $friends1 = DB::table('friendships')
            ->leftJoin('users', 'users.id', 'friendships.user_requested')// who is not loggedin but send request to
            ->where('status', 1)
            ->where('requester', $uid)// who is loggedin
            ->get();
        $friends2 = DB::table('friendships')
            ->leftJoin('users', 'users.id', 'friendships.requester')
            ->where('status', 1)
            ->where('user_requested', $uid)
            ->get();
        $friends = array_merge($friends1->toArray(), $friends2->toArray());
        return view('newMessage', compact('friends', $friends));
    }

    public function sendNewMessage(Request $request)
    {
        $msg = $request->msg;
        $friend_id = $request->friend_id;
        $myID = Auth::user()->id;
        //check if conversation already started or not
        $checkCon1 = DB::table('conversation')->where('user_one', $myID)
            ->where('user_two', $friend_id)->get(); // if loggedin user started conversation
        $checkCon2 = DB::table('conversation')->where('user_two', $myID)
            ->where('user_one', $friend_id)->get(); // if loggedin recviced message first
        $allCons = array_merge($checkCon1->toArray(), $checkCon2->toArray());
        if (count($allCons) != 0) {
            // old conversation
            $conID_old = $allCons[0]->id;
            //insert data into messages table
            $MsgSent = DB::table('messages')->insert([
                'user_from' => $myID,
                'user_to' => $friend_id,
                'msg' => $msg,
                'conversation_id' => $conID_old,
                'status' => 1
            ]);
        } else {
            // new conversation
            $conID_new = DB::table('conversation')->insertGetId([
                'user_one' => $myID,
                'user_two' => $friend_id
            ]);
            echo $conID_new;
            $MsgSent = DB::table('messages')->insert([
                'user_from' => $myID,
                'user_to' => $friend_id,
                'msg' => $msg,
                'conversation_id' => $conID_new,
                'status' => 1
            ]);
            $name = DB::table('users')
                ->where('id', $myID)
                ->value('name');
            $notifications = new notifications;
            $notifications->user_hero = $friend_id;
            $notifications->note = 'Masz nową wiadomość od uzytkwnika ' . $name;
            $notifications->user_logged = $myID;
            $notifications->status = '1'; // nieodczytane powiadomienie
            $notifications->save();

            if ($notifications)
                return back()->with('msg', 'Dziękujemy za przesłanie zgłoszenia. Zapoznamy się z nim jak najszybciej !');
        }
    }

    public function jobs()
    {

        return view('profile.jobs');
    }

    public function job($id)
    {
        $jobs = DB::table('users')
            ->leftJoin('jobs', 'users.id', 'jobs.company_id')
            ->where('jobs.id', $id)
            ->get();
        return view('profile.job', compact('jobs'));
    }

    public function addNotiProfile(Request $request)
    {
        $text = $request->text;
        $id = $request->id;
        $uid = Auth::user()->id;

        $createNoti = DB::table('services')
            ->insert(['user_id' => $uid, 'profile_id' => $id, 'excuse' => $text,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString()]);

        $query = DB::table('users')->where('role_id', 4)->get();
        foreach ($query as $q) {
            $idd = $q->id;
            $moderators[] = $idd;
        }
        $query1 = DB::table('users')
            ->leftJoin('profiles', 'users.id', 'profiles.user_id')
            ->where('profiles.id', $id)
            ->value('name');
        foreach ($moderators as $mod) {
            $notifications = new notifications;
            $notifications->user_hero = $mod;
            $notifications->note = 'Zgłoszenie profilu nr : ' . $id . ' użytkownika ' . $query1 . ', treść: ' . $text;
            $notifications->user_logged = Auth::user()->id;
            $notifications->status = '1'; // nieodczytane powiadomienie
            $notifications->save();
        }
        if ($notifications)
            return back()->with('msg', 'Dziękujemy za przesłanie zgłoszenia. Zapoznamy się z nim jak najszybciej !');
    }

}
