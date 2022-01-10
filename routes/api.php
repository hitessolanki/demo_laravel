<?php

use Illuminate\Http\Request;
// use App\Post;
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
// Route::get("/post","PostController@index");
Route::post("/user","UserController@store");
Route::put("/user","UserController@update");
Route::delete("/user","UserController@delete");
Route::get("/user","UserController@show");
Route::prefix('v1')->group(function () {
	Route::apiResource('user','UserController');
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::apiResource('user','UserController');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
