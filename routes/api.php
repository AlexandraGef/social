<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//search
Route::post('/search', function (Request $request) {
    $queryString = $request->queryString;
    if ($queryString == '') {
        $all = [];
        return response()->json($all);
    } else {
        $users = App\User::where('name', 'like', '%' . $queryString . '%')->get();
        $groups = App\Groups::where('name', 'like', '%' . $queryString . '%')->get();
        $all = array_merge($users->toArray(), $groups->toArray());
        return response()->json($all);
    }
});