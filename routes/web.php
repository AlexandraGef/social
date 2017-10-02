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
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
Route::get('/', function () {
    return view('welcome');
});
/*
 *GUEST
 */


Route::group(['middleware' => 'guest'], function () {
    Route::get('/zapomnianeHaslo', function () {
        return view('auth.forgotPassword');
    });

    Route::post('setToken', 'AuthController@setToken');
    /*
     * get random token by email
     */
    Route::get('/getToken/{token}', 'AuthController@getToken');
    //update password
    Route::get('setPass', 'AuthController@setPass');
});

Auth::routes();
/*
 * USER
 */
Route::group(['middleware' => 'auth'], function () {

    Route::get('/profil/{slug}', 'ProfileController@index');

    Route::get('/zmienZdjecie', function () {
        return view('profile.pic');
    });
    Route::post('/wgrajZdjecie', 'ProfileController@uploadPhoto');

    Route::get('/edytujProfil', 'ProfileController@editProfileForm');

    Route::post('/aktualizujProfil', 'ProfileController@updateProfile');

    Route::get('/czyWyslaneZapro', 'ProfileController@sendReq');

    Route::get('/dodajZnajomego/{id}', 'ProfileController@sendRequest');

    Route::get('/zaproszenia', 'ProfileController@requests');

    Route::get('/akceptuj/{name}/{id}', 'ProfileController@accept');

    Route::get('/znajomi', 'ProfileController@friends');

    Route::get('/moiZnajomi', 'ProfileController@myFriends');

    Route::get('/checkFriends/{id}', 'ProfileController@checkFriends');

    Route::get('/odrzuc/{id}', 'ProfileController@requestRemove');

    Route::get('/powiadomienia/{id}', 'NotiController@notifications');

    Route::get('/usunPowiadomienie/{id}', 'NotiController@deleteNotifications');

    Route::get('/usun/{id}', 'ProfileController@friendRemove');

    Route::get('/usunZnajomego/{id}', 'ProfileController@friendRemove2');

    Route::get('/home', 'HomeController@index');

    Route::get('/uzytkownicy', 'ProfileController@findUsers');

    Route::get('/posty', 'PostsController@findPosts');

    Route::post('/dodajPost', 'PostsController@addPost');

    Route::post('/edytujPost', 'PostsController@editPost');
    //NOTIFICATION
    Route::get('/zglosPost/{id}', function ($id) {

        return view('notifi.addNotiPosts', compact('id', $id));
    });
    Route::get('/zglosKomentarz/{id}', function ($id) {

        return view('notifi.addNotiComment', compact('id', $id));
    });
    Route::get('/zglosProfil/{id}', function ($id) {

        return view('notifi.addNotiProfile', compact('id', $id));
    });
    Route::get('/zglosOdpowiedz/{id}', function ($id) {

        return view('notifi.addNotiAnswer', compact('id', $id));
    });
    Route::get('/zglosGrupe/{id}', function ($id) {

        return view('notifi.addNotiGroup', compact('id', $id));
    });
    Route::post('/dodajZgloszeniePostu', 'PostsController@addNotiPost');
    Route::post('/dodajZgloszenieKomentarza', 'PostsController@addNotiCom');
    Route::post('/dodajZgloszenieOdpowiedzi', 'PostsController@addNotiAnswer');
    Route::post('/dodajZgloszenieProfilu', 'ProfileController@addNotiProfile');
    Route::post('/dodajZgloszenieGrupy', 'GroupsController@addNotiGroup');
    Route::get('/deletePost/{id}', 'PostsController@deletePost');
    Route::get('/noti', 'NotiController@noti');
    Route::get('/zgloszenia', 'NotiController@index');
    Route::get('/usunZgloszenie/{id}', 'NotiController@deleteNoti');
    /*
     *MESSAGES
     */
    Route::get('/wiadomosci', function () {
        return view('messages');
    });

    Route::get('/getMessages', function () {
        $allUsers1 = DB::table('users')
            ->Join('conversation', 'users.id', 'conversation.user_one')
            ->where('conversation.user_two', Auth::user()->id)
            ->get();


        $allUsers2 = DB::table('users')
            ->Join('conversation', 'users.id', 'conversation.user_two')
            ->where('conversation.user_one', Auth::user()->id)
            ->get();
        return array_merge($allUsers1->toArray(), $allUsers2->toArray());
    });

    Route::get('/getMessages/{id}', function ($id) {
        //check conversation
        $userMsg = DB::table('messages')
            ->join('users', 'users.id', 'messages.user_from')
            ->where('messages.conversation_id', $id)->get();
        return $userMsg;
    });

    Route::post('/wyslijWiadomosc', 'ProfileController@sendMessage');
    Route::get('/noweWiadomosci', 'ProfileController@newMessage');
    Route::post('/wyslijNowaWiadomosc', 'ProfileController@sendNewMessage');
    /*
     * JOBS OFFERS FOR USERS
     */
    Route::get('/praca', 'profileController@jobs');
    Route::get('/jobs', function () {
        $jobs = DB::table('users')
            ->Join('jobs', 'users.id', 'jobs.company_id')
            ->get();
        return $jobs;
    });
    Route::get('/szczegolyOferty/{id}', 'profileController@job');
    /*
     * LIKES
     */
    Route::get('/lubie/{id}', 'PostsController@likePost');
    Route::get('/nielubie/{id}', 'PostsController@unlikePost');
    //COMMENTS
    Route::post('dodajKomentarz', 'PostsController@addComment');
    Route::get('usunKomentarz/{id}', 'PostsController@deleteComment');

    //add answers
    Route::post('dodajOdpowiedz', 'PostsController@addAnswer');
    Route::get('usunOdpowiedz/{id}', 'PostsController@deleteAnswer');

    //group
    Route::get('/grupy', 'GroupsController@index');
    Route::get('/groups', 'GroupsController@groups');
    Route::get('/grupa/{slug}', 'GroupsController@group');
    Route::get('/utworzGrupe', function () {

        return view('group.addGroup');
    });
    Route::post('/newGroup', 'GroupsController@createGroup');
    Route::get('/dolaczDoGrupy/{id}', 'GroupsController@joinToGroup');
    Route::get('/odejdzZGrupy/{id}/{groupId}', 'GroupsController@leaveGroup');
    Route::get('/edytujGrupe/{id}', 'GroupsController@editGroupForm');
    Route::get('/zmienZdjecieGrupy/{id}', 'GroupsController@editGroupAv');
    Route::post('/aktualizujGrupe', 'GroupsController@updateGroup');
    Route::post('/wgrajAvatarGrupy', 'GroupsController@uploadAvatar');
    Route::post('/dodajPostGrupy', 'GroupsController@addGroupPost');
    Route::get('/czlonkowieGrupy/{id}', 'GroupsController@groupMembers');
    Route::get('/dolaczDoGrupy/{id}', 'GroupsController@joinToGroup');
    Route::get('/mojeGrupy', 'GroupsController@myGroups');
    Route::get('usunGrupe/{id}', 'GroupsController@deleteGroup');

});
/*
 * COMPANY
 */
Route::group(['prefix' => 'firma', 'middleware' => ['auth', 'company']], function () {
    Route::get('/', 'companyController@index');

    Route::get('/dodajOfertePracy', function () {
        return view('company.addJob');
    });

    Route::post('/dodajOferteSubmit', 'companyController@addJobSubmit');
    Route::get('/OfertyPracy', 'companyController@viewJobs');
    Route::get('/pokazSzczegolyOfert', 'companyController@offersDetal');

});






