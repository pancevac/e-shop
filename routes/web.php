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

Route::get('dev/{order}', 'Web\CheckoutsController@showOrder');

Route::get('/admin', function () {
    return view('layouts/admin-app');
});

Route::get('theme', function () {
    return view('pages.product');
});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

/**
 * Routes for login
 */
Route::get('/prijava', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/prijava', 'Auth\LoginController@login')->name('login.post');
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
 * Routes for customers
 */
Route::get('profil', 'Web\CustomersController@profile')->name('profile')->middleware('verified');
Route::post('profil', 'Web\CustomersController@updateProfile')->name('profile.update')->middleware('verified');
Route::post('change-password', 'Web\CustomersController@changePassword')->name('profile.change_password')->middleware('verified');

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
Route::post('/shop/{categories}/{slug}/{code}', 'Web\CommentsController@store')->where('categories', '.*');

/**
 * Route for updating and deleting products shopping cart
 */
Route::put('/korpa/{rowId}', 'Web\CartsController@shoppingCartUpdate');
Route::delete('/korpa/{rowId}', 'Web\CartsController@shoppingCartDelete');
Route::get('/korpa', 'Web\CartsController@showShoppingCartPage')->name('shopping-cart.index');
Route::post('/korpa/kupon', 'Web\CartsController@coupon');

/**
 * Routes for customer wish-list
 */
Route::get('/lista-zelja', 'Web\WishListsController@showWishListPage')->name('wishList')->middleware('verified');
Route::post('/lista-zelja', 'Web\WishlistsController@addToWishList')->name('wishList.add')->middleware('verified');
Route::delete('/lista-zelja/{code}', 'Web\WishlistsController@removeFromWishList')->name('wishList.delete')->middleware('verified');

/**
 * Routes for checkout page
 */
Route::get('/checkout', 'Web\CheckoutsController@checkoutPage')->name('checkout');
Route::post('/checkout', 'Web\CheckoutsController@submitCheckout')->name('checkout.post');

/**
 * Routes for orders
 */
Route::get('/narudzbine', 'Web\CustomersController@orders')->name('orders');
Route::get('/narudzbina/{order}', 'Web\CustomersController@showOrder')->name('orders.show');

Route::get('product/{code}', function (\Illuminate\Http\Request $request) {
    $product = \App\Product::whereCode($request->code)->first();
    $product->gallery->each->append(['gallery_image', 'product_thumbnail']);
    return view('pages.product', [
        'product' => $product,
    ]);
});