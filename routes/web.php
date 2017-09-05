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

Auth::routes();
Route::group(['middleware' => 'auth'], function (){
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/profil/{slug}', 'ProfileController@index');

    Route::get('/zmienZdjecie',[
        'uses' => '\Bevy\Http\Controllers\ProfileController@getPic',
    ]);

    Route::post('/wgrajZdjecie','ProfileController@uploadPhoto');

    Route::get('editProfile', function() {
        return view('profile.editProfile');
    });
});




