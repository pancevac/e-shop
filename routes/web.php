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

Route::get('/', 'Web\HomeController@index')->name('home');

Route::get('/admin', function () {
    return view('layouts/admin-app');
});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

/**
 * Routes for login
 */
Route::get('/prijava', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/prijava', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
/**
 * Routes for register
 */
Route::get('/registracija', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/registracija', 'Auth\RegisterController@register');
/**
 * Routes for verification
 */
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

/**
 * Route to shop category
 */
Route::get('/shop/{categories}', 'Web\ShopController@shopCategory')->where('categories', '.*')->name('shop.category');

/**
 * Route to product
 */
Route::get('/shop/{categories}/{slug}/{code}', 'Web\ShopController@product')->where('categories', '.*')->name('shop.product');

/**
 * Route to adding product to cart
 */
Route::post('/shop/{categories}/{slug}/{code}/shoppingCart', 'Web\CartsController@ShoppingCartStore')->where('categories', '.*');

/**
 * Route to add review on product
 */
Route::post('/shop/{categories}/{slug}', 'Web\CommentsController@store')->where('categories', '.*');

/**
 * Route for updating and deleting products shopping cart
 */
Route::post('/korpa/update', 'Web\CartsController@shoppingCartUpdate');
Route::post('/korpa/delete', 'Web\CartsController@shoppingCartDelete');
Route::get('/korpa', 'Web\CartsController@shoppingCart')->name('shopping-cart.index');
