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
    return view('home');
});

//Route::get('/users', [
//    'uses' => 'UserController@index',
//    'as' => 'users'
//]);
//Route::get('/users/{id}', [
//    'uses' => 'UserController@show',
//    'as' => 'users.show'
//]);
//Route::post('/users', [
//    'uses' => 'UserController@store',
//    'as' => 'users.store'
//]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/manager/product', [
    'uses' => 'manager\ProductController@index',
    'as' => 'manager.products.index'
]);
Route::get('/admin/dashboard', [
    'uses' => 'OtherController@dashboard',
    'as' => 'admin.dashboard'
]);
Route::get('/manager/product/datatable', [
    'uses' => 'manager\ProductController@datatable',
    'as' => 'manager.products.datatable'
]);
Route::get('/manager/product/{id}', [
    'uses' => 'manager\ProductController@edit',
    'as' => 'manager.products.edit'
]);
///products/{{$product->id}}/stock/"+$(this).val()
Route::get('/manager/products/{id}/stock/{stock}', [
    'uses' => 'manager\ProductController@change_stock',
    'as' => 'manager.products.change_stock'
]);

Route::get('/info/{active}', [
    'uses' => 'OtherController@index',
    'as' => 'info'
]);


Route::post('/admin/users/{id}', [
    'uses' => 'admin\UserController@update',
    'as' => 'users.update'
]);
Route::post('/admin/users', [
    'uses' => 'admin\UserController@store',
    'as' => 'users.store'
]);
Route::post('/admin/products/{id}', [
    'uses' => 'admin\ProductController@update',
    'as' => 'products.update'
]);
Route::get('/admin/users', [
    'uses' => 'admin\UserController@index',
    'as' => 'admin.users'
]);
Route::get('/admin/products', [
    'uses' => 'admin\ProductController@index',
    'as' => 'admin.products'
]);
Route::get('/admin/users/create', [
    'uses' => 'admin\UserController@create',
    'as' => 'admin.users.create'
]);
Route::get('/admin/user/edit/{id}', [
    'uses' => 'admin\UserController@edit',
    'as' => 'admin.users.edit'
]);
Route::get('/admin/categories', [
    'uses' => 'admin\CategoryController@index',
    'as' => 'admin.categories'
]);
//Route::get('/admin/products/create', [
//    'uses' => 'admin\ProductController@create',
//    'as' => 'admin.products.create'
//]);
Route::post('/products/create', [
    'uses' => 'admin\ProductController@store',
    'as' => 'products.store'
]);
Route::get('/admin/products/edit/{id}', [
    'uses' => 'admin\ProductController@edit',
    'as' => 'products.edit'
]);
Route::get('/admin/products/{id}', [
    'uses' => 'admin\ProductController@show',
    'as' => 'products.show'
]);
Route::get('/admin/orders', [
    'uses' => 'admin\OrderController@index',
    'as' => 'admin.orders'
]);
Route::get('/admin/orders/{id}', [
    'uses' => 'admin\OrderController@show',
    'as' => 'orders.show'
]);
Route::match(['get', 'post'], '/browse', [
    'uses' => 'customer\CustomerController@index',
    'as' => 'browse'
]);
Route::get('/customer/cart', [
    'uses' => 'customer\CustomerController@cart',
    'as' => 'customer.cart'
]);
Route::post('/cart/order', [
    'uses' => 'customer\CustomerController@cart_order',
    'as' => 'cart.order'
]);
Route::get('/customer/product/{id}/{page}', [
    'uses' => 'customer\CustomerController@show_product',
    'as' => 'customer.product'
]);
Route::get('/customer/cart/add/{id}', [
    'uses' => 'customer\CustomerController@add_to_cart',
    'as' => 'customer.cart.add'
]);
Route::get('/customer/order/{id}', [
    'uses' => 'customer\CustomerController@order',
    'as' => 'customer.order'
]);
Route::post('/customer/review', [
    'uses' => 'customer\CustomerController@make_review',
    'as' => 'customer.review'
]);
Route::get('/customer/review/remove/{id}', [
    'uses' => 'customer\CustomerController@remove_review',
    'as' => 'customer.review.remove'
]);
Route::get('/customer/profile', [
    'uses' => 'customer\ProfileController@index',
    'as' => 'customer.profile'
]);
Route::post('/customer/profile/{id}', [
    'uses' => 'customer\ProfileController@update',
    'as' => 'customer.profile.update'
]);
Route::get('/customer/orders', [
    'uses' => 'customer\ProfileController@show_orders',
    'as' => 'customer.orders.show'
]);
Route::get('/customer/orders/datatable', [
    'uses' => 'customer\ProfileController@order_datatable',
    'as' => 'customer.orders.datatable'
]);
Route::get('/customer/orders/{id}', [
    'uses' => 'customer\ProfileController@show_order',
    'as' => 'customer.order.show'
]);
///customer/order/remove/"+order_id,
Route::get('/customer/order/remove/{order_id}', [
    'uses' => 'customer\ProfileController@remove_order',
    'as' => 'customer.order.remove'
]);
Route::get('/admin/reports', [
    'uses' => 'admin\ReportController@index',
    'as' => 'admin.reports'
]);
Route::post('/admin/reports/products', [
    'uses' => 'admin\ReportController@products',
    'as' => 'admin.reports.products'
]);
Route::post('/admin/reports/orders', [
    'uses' => 'admin\ReportController@orders',
    'as' => 'admin.reports.orders'
]);
Route::post('/admin/reports/sales', [
    'uses' => 'admin\ReportController@sales',
    'as' => 'admin.reports.sales'
]);
Route::get('/admin/reports/{id}', [
    'uses' => 'admin\ReportController@order',
    'as' => 'orders.report'
]);


