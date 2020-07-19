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
// Route::get('/test', function () {
//     $remainder = fmod(4,3);
//     return $remainder;
// });


// Route::get('/', function () {
//     return view('welcome');
// });

// // auth
// Auth::routes();

Auth::routes(['verify' => true]); //for email verification==>['verify' => true]

// Route::get('profile', function () { //for email verification test =>temp
//     // Only verified users may enter...
//     return "This is profile";
// })->middleware('verified');

// Route::get('showVerificationMsg', function () { //register 후에 email verification을 위하여 삽입.
//     //만약 이메일 인증이 되었으면 아래 메세지가 나오고(그럴리는 없지만...) 그렇지 않으면
//     //resources/views/auth/verify.blade.php에 있는 메시가 나온다.[=>middleware('verified')]
//     return "You have been already verified."; //현재는 register 후에 곧바로 이 url로 오도록 RegisterController에 코딩
// })->middleware('verified');                //되어 있다.
Route::get('showVerificationMsg','HomeController@showVerificationMsg')->middleware('verified');

// home
Route::get('/', 'HomeController@home');
// Route::get('/home', 'HomeController@index')->name('home'); //=> do not delete for testing.
Route::get('/home', 'HomeController@home')->name('home.home');
Route::get('/home/search', 'HomeController@search')->name('home.search');
Route::get('/allCategory', 'HomeController@allCategory')->name('home.allCategory');
Route::post('/home/deletCookieProduct', 'HomeController@deletCookieProduct')->name('home.deletCookieProduct');

// cart
Route::get('/cart/addToCart', 'CartController@addTocart')->name('cart.addToCart');
Route::get('/cart/deleteInCart', 'CartController@deleteInCart')->name('cart.deleteInCart');
Route::get('/cart/deleteAllInCart', 'CartController@deleteAllInCart')->name('cart.deleteAllInCart');
Route::get('/cart/changeInCart', 'CartController@changeInCart')->name('cart.changeInCart');
Route::get('/cart/getCart', 'CartController@getCart')->name('cart.getCart');
Route::get('/cart/showCart', 'CartController@showCart')->name('cart.showCart');
//Route::get('/cart/countCart', 'CartController@countCart');//do not delete observing...

// product
Route::get('/product/details/{id}', 'ProductController@details')->name('product.details');
Route::get('/product/showProductsCategoryBC/{id}', 'ProductController@showProductsCategoryBC')->name('product.showProductsCategoryBC');
Route::get('/product/showProductsCategoryC/{id}', 'ProductController@showProductsCategoryC')->name('product.showProductsCategoryC');
Route::get('/product/showProductsCategoryAB/{id}', 'ProductController@showProductsCategoryAB')->name('product.showProductsCategoryAB');

// Order
Route::get('/order/orderDetails', 'OrderController@orderDetails')->name('order.orderDetails')->middleware('auth','verified','can:isUser');
Route::get('/order/orderDetailsByTerm', 'OrderController@orderDetailsByTerm')->name('order.orderDetailsByTerm')->middleware('auth','verified','can:isUser');
Route::get('/order/getOrderDetails', 'OrderController@getOrderDetails')->name('order.getOrderDetails')->middleware('auth','verified','can:isUser');
Route::get('/order/orderDetailsById/{id}', 'OrderController@orderDetailsById')->name('order.orderDetailsById')->middleware('auth','verified','can:isUser');

// checkout
Route::post('/checkout/getCheckout', 'CheckoutController@getCheckout')->name('checkout.getCheckout')->middleware('auth','verified','can:isUser');//for vue
Route::get('/checkout/showCheckout', 'CheckoutController@showCheckout')->name('checkout.showCheckout')->middleware('auth','verified','can:isUser');//for vue
Route::post('checkout/payment', 'CheckoutController@payment')->name('checkout.payment')->middleware('auth','verified','can:isUser');
Route::get('/checkout/payNow/{address}/{addressee}/{addressId}', 'CheckoutController@payNow')->name('checkout.payNow')->middleware('auth','verified','can:isUser');//for blade
// Route::get('/checkout/showPayNow', 'CheckoutController@showPayNow')->name('checkout.showPayNow')->middleware('auth','verified','can:isUser');//do not delete for vue.js
// Route::get('/checkout/getPaymentIntent', 'CheckoutController@getPaymentIntent')->name('checkout.getPaymentIntent')->middleware('auth','verified','can:isUser');//do not delete for vue.js

// address
Route::post('/checkout/deleteAddress', 'CheckoutController@deleteAddress')->name('checkout.deleteAddress')->middleware('auth','verified','can:isUser');
Route::get('/checkout/getAddresses', 'CheckoutController@getAddresses')->name('checkout.getAddresses')->middleware('auth','verified','can:isUser');

// seller/option ==> for manyTo many test
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

// seller/seller
Route::get('/seller', 'Seller\SellerController@index')->name('seller.seller.index')->middleware('auth','can:isSeller');
Route::post('/seller/customerOrders', 'Seller\SellerController@customerOrders')->name('seller.seller.customerOrders')->middleware('auth','can:isSeller');
Route::get('/seller/customerOrdersByTerm', 'Seller\SellerController@customerOrdersByTerm')->name('seller.seller.customerOrdersByTerm')->middleware('auth','can:isSeller');
Route::get('/seller/showCustomerOrders', 'Seller\SellerController@showCustomerOrders')->name('seller.seller.showCustomerOrders')->middleware('auth','can:isSeller');
Route::post('/seller/editOrder', 'Seller\SellerController@editOrder')->name('seller.seller.editOrder')->middleware('auth','can:isSeller');

// admin/admin
Route::get('/admin', 'Admin\AdminController@index')->name('admin.admin.index')->middleware('auth','can:isAdmin');

// admin/category
Route::get('/admin/category', 'Admin\AdminController@showCategoryForm')->name('admin.category.showCategoryForm')->middleware('auth','can:isAdmin');
Route::post('/admin/getAllcategories', 'Admin\AdminController@getAllcategories')->name('admin.category.getAllcategories')->middleware('auth','can:isAdmin');
Route::post('/admin/getCategoryAbyId', 'Admin\AdminController@getCategoryAbyId')->name('admin.category.getCategoryAbyId')->middleware('auth','can:isAdmin');
Route::post('/admin/getCategoryBbyId', 'Admin\AdminController@getCategoryBbyId')->name('admin.category.getCategoryBbyId')->middleware('auth','can:isAdmin');
Route::post('/admin/getCategoryCbyId', 'Admin\AdminController@getCategoryCbyId')->name('admin.category.getCategoryCbyId')->middleware('auth','can:isAdmin');
