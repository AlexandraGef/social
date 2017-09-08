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


Route::post('/dodajPost', 'PostsController@addPost');


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

});




