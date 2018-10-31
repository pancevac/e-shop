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

Route::get('/', 'Web\HomeController@index');

Route::get('/admin', function () {
    return view('layouts/admin-app');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/shop/{categories}/{slug}', 'Web\ShopController@product')->where('categories', '.*');
Route::get('/shop/{category}', 'Web\ShopController@shopCategory');
