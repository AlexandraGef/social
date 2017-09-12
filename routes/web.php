<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/zapomnianeHaslo', function () {
        return view('auth.forgotPassword');
    });

    Route::post('setToken', 'AuthController@setToken');
//get random token by email
    Route::get('/getToken/{token}', function ($token) {
        $getData = DB::table('password_resets')->where('token', $token)->get();
        if (count($getData) != 0) {
            return view('auth.setPassword')->with('data', $getData);
        } else {
            return redirect('/zapomnianeHaslo')->with('err', 'Podany token już wygasł !');
        }
    });
    //update password
    Route::get('setPass', 'AuthController@setPass');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function (){

    Route::get('/profil/{slug}', 'ProfileController@index');

    Route::get('/zmienZdjecie', function(){
        return view('profile.pic');
    });
    Route::post('/wgrajZdjecie','ProfileController@uploadPhoto');

    Route::get('/edytujProfil', 'ProfileController@editProfileForm');

    Route::post('/aktualizujProfil', 'ProfileController@updateProfile');

    Route::get('/znajdzZnajomych', 'ProfileController@findFriends');

    Route::get('/dodajZnajomego/{id}', 'ProfileController@sendRequest');

    Route::get('/zaproszenia', 'ProfileController@requests');

    Route::get('/akceptuj/{name}/{id}', 'ProfileController@accept');

    Route::get('/znajomi', 'ProfileController@friends');

    Route::get('/odrzuc/{id}', 'ProfileController@requestRemove');

    Route::get('/powiadomienia/{id}', 'ProfileController@notifications');



    Route::get('/usun/{id}', 'ProfileController@friendRemove');

    Route::get('/home','PostsController@index');
    Route::get('/posty', function(){
        $posts_json = DB::table('posts')
            ->leftJoin('users','posts.user_id','users.id')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return $posts_json;

    });
    Route::post('/dodajPost', 'PostsController@addPost');

    Route::get('/wiadomosci', function(){
        return view('messages');
    });
/////////////////////////////WIADOMOSCI
/// ///////////////////////////////////////////////
    Route::get('/getMessages', function(){
        $allUsers1 = DB::table('users')
            ->Join('conversation','users.id', 'conversation.user_one')
            ->where('conversation.user_two', Auth::user()->id)
            ->get();


        $allUsers2 = DB::table('users')
            ->Join('conversation','users.id', 'conversation.user_two')
            ->where('conversation.user_one', Auth::user()->id)
            ->get();
        return array_merge($allUsers1->toArray(), $allUsers2->toArray());
    });

    Route::get('/getMessages/{id}', function($id){
        //check conversation
      /*  $checkCon = DB::table('conversation')
            ->where('user_one',Auth::user()->id)
            ->where('user_two',$id)
            ->get();
            //fetch msgs
            if(count($checkCon)!=0){
               // echo $checkCon[0]->id;
                $userMsg = DB::table('messages')
                    ->where('messages.conversation_id', $checkCon[0]->id)->get();
                return $userMsg;

        }else{
            echo "Brak wiadomości";
        }*/
        $userMsg = DB::table('messages')
            ->join('users', 'users.id','messages.user_from')
            ->where('messages.conversation_id', $id)->get();
        return $userMsg;
    });

    Route::post('/wyslijWiadomosc', 'ProfileController@sendMessage');
    Route::get('/noweWiadomosci','ProfileController@newMessage');
    Route::post('/wyslijNowaWiadomosc', 'ProfileController@sendNewMessage');
});

Route::group(['prefix' => 'company', 'middleware' => ['auth','company']],function() {
    Route::get('/', function () {
        echo " hell from company";
    });
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth','admin']],function() {
    Route::get('/', function () {
        echo " hell from admin";
    });
});



