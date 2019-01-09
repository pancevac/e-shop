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

Route::middleware('auth:api')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user()->append('profileImage');
    });

    // Users CRUD
    Route::resource('users', 'Api\UsersController')->except(['show', 'create']);
    Route::post('users/{id}/uploadImage', 'Api\UsersController@uploadImage');
    // Brands CRUD
    Route::resource('brands', 'Api\BrandsController')->except(['show', 'create']);
    Route::get('brands/lists', 'Api\BrandsController@lists');
    // Categories CRUD
    Route::resource('categories', 'Api\CategoriesController')->except(['show', 'create']);
    Route::get('categories/lists', 'Api\CategoriesController@lists');
    Route::get('categories/sort', 'Api\CategoriesController@sort');
    Route::post('categories/order', 'Api\CategoriesController@saveOrder');
    Route::post('categories/{id}/uploadImage', 'Api\CategoriesController@uploadImage');
    // Properties CRUD
    Route::get('properties/lists', 'Api\PropertiesController@lists');
    Route::post('properties/categories', 'Api\PropertiesController@listsByCategories');
    Route::resource('properties', 'Api\PropertiesController')->except(['show', 'create']);
    // Attribute CRUD
    Route::resource('attributes', 'Api\AttributesController')->except(['show', 'create']);
    Route::post('attributes/search', 'Api\AttributesController@search');
    // Tag CRUD
    Route::resource('tags', 'Api\TagsController')->except(['show', 'create']);
    Route::get('tags/lists', 'Api\TagsController@lists');
    // Product CRUD
    Route::post('products/search', 'Api\ProductsController@search');
    Route::resource('products', 'Api\ProductsController')->except(['show', 'create']);
    Route::post('products/{id}/uploadImage', 'Api\ProductsController@uploadImage');
    Route::get('products/{id}/gallery', 'Api\ProductsController@gallery');
    Route::post('products/{id}/uploadGallery', 'Api\ProductsController@uploadGallery');
    // Gallery
    Route::delete('galleries/{id}', 'Api\GalleriesController@destroy');
    // Permission CRUD
    Route::get('permissions/models', 'Api\PermissionsController@getModels');
    Route::get('permissions/abilities', 'Api\PermissionsController@getAbilities');
    Route::get('permissions/lists', 'Api\PermissionsController@lists');
    Route::resource('permissions', 'Api\PermissionsController')->except(['show', 'create']);
    // Role CRUD
    Route::get('roles/lists', 'Api\RolesController@lists');
    Route::resource('roles', 'Api\RolesController')->except(['show', 'create']);
    // Menu CRUD
    Route::resource('menus', 'Api\MenusController')->except(['show', 'create']);
    // Menu-link CRUD
    Route::get('menu-links/lists', 'Api\MenuLinksController@lists');
    Route::get('menu-links/sort', 'Api\MenuLinksController@sort');
    Route::post('menu-links/sort/{menu_id}', 'Api\MenuLinksController@saveSort');
    Route::resource('menu-links', 'Api\MenuLinksController')->except(['show', 'create']);
    // Coupons CRUD
    Route::resource('coupons', 'Api\CouponsController')->except(['show', 'create']);
    // Orders CRUD
    Route::resource('orders', 'Api\OrdersController')->except(['show', 'create', 'store']);
    // Customers CRUD
    Route::resource('customers', 'Api\CustomersController')->except(['show', 'create', 'store']);
    // Widgets CRUD
    Route::resource('widgets', 'Api\WidgetsController')->except(['show', 'create']);
    Route::post('widgets/{id}/uploadImage', 'Api\WidgetsController@uploadImage');
    // Banners CRUD
    Route::resource('banners', 'Api\BannersController')->except(['show', 'create']);
    Route::post('banners/{banner}/uploadImage', 'Api\BannersController@uploadImage');

});