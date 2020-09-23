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

Auth::routes();

Route::get('/app', function () {
    return view('spa');
});


Route::get('/', 'IndexController@index')->name('index');

Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/cart', 'CartController@store');
Route::delete('/cart', 'CartController@destroy');

Route::post('/reviews', 'ReviewsController@store')->name('reviews.store');
Route::delete('/reviews/{review}', 'ReviewsController@destroy')->name('reviews.destroy')->middleware('auth');

Route::middleware('auth')->group(
    function () {
        Route::get('/products', 'ProductController@index')->name('products');
        Route::get('/products/create', 'ProductController@create')->name('products.create');
        Route::get('/products/{product}/edit', 'ProductController@edit')->name('products.edit');
        Route::get('/products/{product}', 'ProductController@show')->name('products.show')->withoutMiddleware('auth');
        Route::post('/products', 'ProductController@store')->name('products.store');
        Route::patch('/products/{product}', 'ProductController@update')->name('products.update');
        Route::delete('/products/{product}', 'ProductController@destroy')->name('products.destroy');

        Route::get('/orders', 'OrderController@index')->name('orders');
        Route::get('/orders/{order}', 'OrderController@show')->name('orders.show');
        Route::post('/orders', 'OrderController@store')->name('orders.store')->withoutMiddleware('auth');
    }
);



