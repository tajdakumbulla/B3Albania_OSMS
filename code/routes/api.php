<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//ORDERS
Route::get('/admin/orders', [
    'uses' => 'admin\OrderController@datatable',
    'as' => 'datatable.orders'
]);
Route::get('/order/{id}/status/{status}', [
    'uses' => 'admin\OrderController@change_status',
    'as' => 'orders.status.change'
]);


//USERS
Route::get('/users', [
    'uses' => 'admin\UserController@index',
    'as' => 'users'
]);
Route::get('/admin/users', [
    'uses' => 'admin\UserController@datatable',
    'as' => 'datatable.users'
]);
Route::get('/users/{id}', [
    'uses' => 'admin\UserController@show',
    'as' => 'users.show'
]);


Route::get('/users/destroy/{id}', [
    'uses' => 'admin\UserController@destroy',
    'as' => 'users.destroy'
]);

//PRODUCTS
Route::get('/products', [
    'uses' => 'admin\ProductController@index',
    'as' => 'products'
]);


Route::get('/admin/products', [
    'uses' => 'admin\ProductController@datatable',
    'as' => 'datatable.products'
]);

Route::post('/products/{id}/add/image', [
    'uses' => 'admin\ProductController@add_image',
    'as' => 'products.add.image'
]);

Route::get('/products/{id}/image/{url}/remove', [
    'uses' => 'admin\ProductController@remove_image',
    'as' => 'products.remove.image'
]);


//PRODUCT-CATEGORY
Route::get('/products/{product_id}/categories/{category_id}/add', [
    'uses' => 'admin\ProductController@add_category',
    'as' => 'products.categories.add'
]);
Route::get('/products/{product_id}/categories/{category_id}/remove', [
    'uses' => 'admin\ProductController@remove_category',
    'as' => 'products.categories.remove'
]);

//CATEGORIES

Route::post('/categories', [
    'uses' => 'admin\CategoryController@store',
    'as' => 'categories.store'
]);
Route::get('/admin/categories/datatable', [
    'uses' => 'admin\CategoryController@datatable',
    'as' => 'datatable.categories'
]);
Route::get('/admin/category/types/datatable', [
    'uses' => 'admin\CategoryTypeController@datatable',
    'as' => 'datatable.category.types'
]);
Route::post('/category/types', [
    'uses' => 'admin\CategoryTypeController@store',
    'as' => 'category.type.store'
]);
Route::get('/category/type/{id}', [
    'uses' => 'admin\CategoryTypeController@show',
    'as' => 'category.type.show'
]);
Route::get('/categories/{id}', [
    'uses' => 'admin\CategoryController@show',
    'as' => 'category.show'
]);

Route::post('/categories/update/{id}', [
    'uses' => 'admin\CategoryController@update',
    'as' => 'categories.update'
]);
Route::post('/category/type/update/{id}', [
    'uses' => 'admin\CategoryTypeController@update',
    'as' => 'category.type.update'
]);
Route::get('/category/type/delete/{id}', [
    'uses' => 'admin\CategoryTypeController@destroy',
    'as' => 'category.type.destroy'
]);
Route::get('/category/delete/{id}', [
    'uses' => 'admin\CategoryController@destroy',
    'as' => 'category.destroy'
]);

//CUSTOMER
Route::get('/customer/{user_id}/favorite/{product_id}', [
    'uses' => 'customer\CustomerController@favorite',
    'as' => 'customer.favorite'
]);
Route::get('/customer/{user_id}/cart/remove/{product_id}', [
    'uses' => 'customer\CustomerController@cart_remove',
    'as' => 'customer.cart.remove'
]);
Route::name('verify')->get('/user/verify/{token}', 'customer\CustomerController@verify');
