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

// Users CRUD
Route::resource('users', 'Api\UsersController')->except(['show', 'create']);
// Brands CRUD
Route::resource('brands', 'Api\BrandsController')->except(['show', 'create']);
Route::get('brands/lists', 'Api\BrandsController@lists');
// Categories CRUD
Route::resource('categories', 'Api\CategoriesController')->except(['show', 'create']);
Route::get('categories/lists', 'Api\CategoriesController@lists');
Route::get('categories/sort', 'Api\CategoriesController@sort');
Route::post('categories/order', 'Api\CategoriesController@saveOrder');
// Properties CRUD
Route::resource('properties', 'Api\PropertiesController')->except(['show', 'create']);
Route::get('properties/lists', 'Api\PropertiesController@lists');
// Attribute CRUD
Route::resource('attributes', 'Api\AttributesController')->except(['show', 'create']);
Route::post('attributes/search', 'Api\AttributesController@search');
// Tag CRUD
Route::resource('tags', 'Api\TagsController')->except(['show', 'create']);
Route::get('tags/lists', 'Api\TagsController@lists');
// Product CRUD
Route::resource('products', 'Api\ProductsController')->except(['show', 'create']);