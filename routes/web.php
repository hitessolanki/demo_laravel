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

// Route::prefix('superadmin')->group(function(){
//     Route::get('login', 'Auth\SuperAdminLoginController@showLoginForm')->name('superAdminLogin');
//     Route::post('login', 'Auth\SuperAdminLoginController@login')->name('superAdminLoginPost');
// });
Route::group(['middleware'=>'customAuth'],function(){
    Route::get('login', 'RestoController@showLoginForm')->name('login');
    Route::get('register', 'RestoController@showRegisterForm')->name('register');
    Route::get('/list','RestoController@listuser')->name('list');
    Route::get('/restolist','RestoController@listResto')->name('resto_list');
    Route::get('/add','RestoController@showAddForm');
    Route::post('/add','RestoController@add');
    Route::get('logout','RestoController@logout');
    // Route::view('login','login');
});
Route::post('registerUser','RestoController@registerUser');
Route::post('loginUser','RestoController@login');


