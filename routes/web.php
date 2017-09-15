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
/*
 * gosc
 */
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
/*
 * uzytkownik
 */
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

    Route::get('/home',function(){
        /*$posts_json = DB::table('posts')
            ->leftJoin('users','posts.user_id','users.id')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return $posts_json;*/
        $posts =  Bevy\posts::with('user','likes','comments.user')
            ->orderBy('created_at','DESC')
            ->get();
        return view('home', compact('posts'));


    });
    Route::get('/posty', function(){
        /*$posts_json = DB::table('posts')
            ->leftJoin('users','posts.user_id','users.id')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return $posts_json;*/
         return Bevy\posts::with('user','likes','comments.user')
             ->orderBy('created_at','DESC')
             ->get();


    });
    Route::post('/dodajPost', 'PostsController@addPost');
    //delete posts
    Route::get('/deletePost/{id}','PostsController@deletePost');
    /*
     * wiadomosci
     */
    Route::get('/wiadomosci', function(){
        return view('messages');
    });

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
    /*
     * oferty dla uzytkownikow
     */
    Route::get('/praca','profileController@jobs');
    Route::get('/szczegolyOferty/{id}', 'profileController@job');
/*
 * polubienia
 */
    Route::get('/lubie/{id}', 'PostsController@likePost');
    Route::get('/nielubie/{id}', 'PostsController@unlikePost');
    //add comments
    Route::post('dodajKomentarz', 'PostsController@addComment');
});
/*
 * firma
 */
Route::group(['prefix' => 'firma', 'middleware' => ['auth','company']],function() {
    Route::get('/', 'companyController@index');

    Route::get('/dodajOfertePracy', function(){
        return view('company.addJob');
    });

    Route::post('/dodajOferteSubmit', 'companyController@addJobSubmit');
    Route::get('/OfertyPracy', 'companyController@viewJobs');

});
/*
 * admin
 */
Route::group(['prefix' => 'admin', 'middleware' => ['auth','admin']],function() {
    Route::get('/', 'adminController@index)');


});



