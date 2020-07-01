<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/test', function () {
    $remainder = fmod(4,3);
    return $remainder;
});


// Route::get('/', function () {
//     return view('welcome');
// });

// auth
Auth::routes();

// home
Route::get('/', 'HomeController@home')->name('home.home');
// Route::get('/home', 'HomeController@index')->name('home'); //=> do not delete for testing.
Route::get('/home', 'HomeController@home')->name('home.home');
Route::get('/home/search', 'HomeController@search')->name('home.search');
Route::get('/allCategory', 'HomeController@allCategory')->name('home.allCategory');

// cart
// Route::get('/cart/addToCart/{id}', 'CartController@addTocart')->name('cart.addToCart');
Route::get('/cart/addToCart', 'CartController@addTocart')->name('cart.addToCart');
Route::get('/cart/deleteInCart/{id}', 'CartController@deleteInCart')->name('cart.deleteInCart');//for blade.php
Route::get('/cart/deleteInCart', 'CartController@deleteInCart')->name('cart.deleteInCart');
Route::get('/cart/deleteAllInCart', 'CartController@deleteAllInCart')->name('cart.deleteAllInCart');
// Route::get('/cart/changeInCart/{id}', 'CartController@changeInCart')->name('cart.changeInCart');//for blade.php
Route::get('/cart/changeInCart', 'CartController@changeInCart')->name('cart.changeInCart');
Route::get('/cart/getCart', 'CartController@getCart')->name('cart.getCart');
Route::get('/cart/showCart', 'CartController@showCart')->name('cart.showCart');
Route::get('/cart/countCart', 'CartController@countCart');

// product
Route::get('/product/details/{id}', 'ProductController@details')->name('product.details');
Route::get('/product/showProductsCategoryBC/{id}', 'ProductController@showProductsCategoryBC')->name('product.showProductsCategoryBC');
Route::get('/product/showProductsCategoryC/{id}', 'ProductController@showProductsCategoryC')->name('product.showProductsCategoryC');
Route::get('/product/showProductsCategoryAB/{id}', 'ProductController@showProductsCategoryAB')->name('product.showProductsCategoryAB');

// Order
Route::get('/order/orderDetails', 'OrderController@orderDetails')->name('order.orderDetails')->middleware('auth','can:isUser');
Route::get('/order/orderDetailsByTerm', 'OrderController@orderDetailsByTerm')->name('order.orderDetailsByTerm')->middleware('auth','can:isUser');
Route::get('/order/getOrderDetails', 'OrderController@getOrderDetails')->name('order.getOrderDetails')->middleware('auth','can:isUser');
Route::get('/order/orderDetailsById/{id}', 'OrderController@orderDetailsById')->name('order.orderDetailsById')->middleware('auth','can:isUser');

// checkout
Route::get('/checkout/checkOut', 'CheckoutController@checkOut')->name('checkout.checkOut')->middleware('auth','can:isUser');
Route::post('checkout/payment', 'CheckoutController@payment')->name('checkout.payment')->middleware('auth','can:isUser');

// seller/option ==> for manyToMany test
Route::get('/seller/showOptionConnections', 'SellerController@showOptionConnections')->name('seller.showOptionConnections');
Route::get('/seller/showProductOptions', 'SellerController@showProductOptions')->name('seller.showProductOptions');//entry point
Route::post('/seller/connectProductOptions', 'SellerController@connectProductOptions')->name('seller.connectProductOptions');
Route::post('/seller/disConnectProductOptions', 'SellerController@disConnectProductOptions')->name('seller.disConnectProductOptions');

// seller/product
Route::get('/seller/product/test/{id}', 'Seller\ProductController@test')->middleware('auth','can:isSeller');
Route::get('/seller/product/showProductInputForm', 'Seller\ProductController@showProductInputForm')->name('seller.product.showProductInputForm')->middleware('auth','can:isSeller');
Route::get('/seller/product/getCategoryAs', 'Seller\ProductController@getCategoryAs')->name('seller.product.getCategoryAs')->middleware('auth','can:isSeller');
Route::get('/seller/product/getCategoryBbyId', 'Seller\ProductController@getCategoryBbyId')->name('seller.product.getCategoryBbyId')->middleware('auth','can:isSeller');
Route::get('/seller/product/getCategoryCbyId', 'Seller\ProductController@getCategoryCbyId')->name('seller.product.getCategoryCbyId')->middleware('auth','can:isSeller');
Route::post('/seller/product/addProduct', 'Seller\ProductController@addProduct')->name('seller.product.addProduct')->middleware('auth','can:isSeller');
Route::get('/seller/product/showMyProducts', 'Seller\ProductController@showMyProducts')->name('seller.product.showMyProducts')->middleware('auth','can:isSeller');
Route::get('/seller/product/getMyProducts', 'Seller\ProductController@getMyProducts')->name('seller.product.getMyProducts')->middleware('auth','can:isSeller');
Route::get('/seller/product/showEditProduct/{id}', 'Seller\ProductController@showEditProduct')->name('seller.product.showEditProduct')->middleware('auth','can:isSeller');
Route::get('/seller/product/getMyProductById', 'Seller\ProductController@getMyProductById')->name('seller.product.getMyProductById')->middleware('auth','can:isSeller');

//seller/seller
Route::get('/seller', 'Seller\SellerController@index')->name('seller.seller.index')->middleware('auth','can:isSeller');
