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
    Route::get('login', 'ProductController@showLoginForm')->name('login');
    // Route::get('register', 'RestoController@showRegisterForm')->name('register');
    Route::get('/list','ProductController@listuser')->name('list');
    Route::get('/categorylist','ProductController@listCategory')->name('category_list');
    Route::get('/add','ProductController@showAddForm')->name('add');
    Route::post('/add','ProductController@addCategory');
    // Product 
    Route::get('/addproduct','ProductController@showAddProductForm')->name('addproduct');
    Route::post('/addproduct','ProductController@addProduct')->name('addproduct');
    Route::get('/productdetails','ProductController@getProductList')->name('getProduct');
    Route::get('/editProduct/{id}','ProductController@editProduct')->name('edit_product');
    Route::get('/deleteProduct/{id}','ProductController@deleteProduct')->name('delete_product');
    Route::post('/updateProduct','ProductController@updateProduct')->name('updateproduct');
    //Category
    Route::get('/editCategory/{id}','ProductController@editCategory')->name('edit_category');
    Route::get('/deleteCategory/{id}','ProductController@deleteCategory')->name('delete_category');
    
    Route::post('/updatecategory','ProductController@updateCategory')->name('updatecategory');
    Route::get('logout','ProductController@logout');
    // Route::view('login','login');
});
Route::post('loginUser','ProductController@login');


