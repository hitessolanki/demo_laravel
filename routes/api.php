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
Route::post("/post","PostController@store");
Route::put("/post","PostController@update");
Route::delete("/post","PostController@delete");
Route::get("/post","PostController@show");
Route::prefix('v1')->group(function () {
	Route::apiResource('post','PostController');
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::apiResource('post','PostController');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
