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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/products', 'ProductController');

Route::resource('/cart', 'CartController');

Route::post('/cart/saveForLater/{cart}', 'CartController@saveForLater');

Route::post('/saveForLater', 'SaveForLaterController@store');

Route::delete('/saveForLater/{id}', 'SaveForLaterController@destroy');

Route::get('empty', function(){
    Cart::instance('savedForLater')->destroy();
});
