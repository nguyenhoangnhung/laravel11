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

// Route::get('/', function () {
//     return view('products.dashboard');
// });

// Route::post('products/adddetail/{id}', 'ProductController@store');




Route::get('store','StoreController@index');
Route::get('store/detail/{id}', 'StoreController@show');

// Route::get('store/cart', 'CartController@index');
use Gloudemans\Shoppingcart\ShoppingcartServiceProvider;
Route::get('/store/cart', function () {
    // Add some items in your Controller.
    Cart::add('192ao12', 'Product 1', 1, 9.99);
    Cart::add('1239ad0', 'Product 2', 2, 5.95, ['size' => 'large']);

    return view('store.cart');
});


Auth::routes();
Route::prefix('admin')->group(function(){
	Route::get('login', 'AdminAuth\LoginController@showLoginForm')->name('adminlogin');
    Route::post('login', 'AdminAuth\LoginController@login')->name('admin.login');
    Route::post('logout', 'AdminAuth\LoginController@logout')->name('adminlogout');

    // Registration Routes...
    Route::get('register', 'AdminAuth\RegisterController@showRegistrationForm')->name('adminregister');
    Route::post('register', 'AdminAuth\RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'AdminAuth\ResetPasswordController@reset');

    Route::middleware('admin.auth')->group(function() {
    	Route::get('dashboard', function() {
    		return view('products.dashboard');

    	});
        Route::get('products', 'ProductController@index');
        Route::get('products/list', 'ProductController@anyData');
        Route::delete('products/{id}','ProductController@destroy');
        Route::post('products', 'ProductController@add');
        Route::post('upload', 'ProductController@upload');
        Route::post('adddetail','SizeColorController@store');
        Route::get('products/show/{id}', 'ProductController@show');

        //store

        //user
        Route::get('users/list', 'DatatablesController@anyData');
        Route::get('users', 'DatatablesController@index');
        Route::delete('users/{id}', 'DatatablesController@destroy');

    });
});

// Route::get('/home', 'HomeController@index')->name('home');
