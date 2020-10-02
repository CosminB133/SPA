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

Route::get('/spa', function () {
    return view('spa');
});

Route::get('/', 'IndexController@index')->name('index');

Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart', 'CartController@store')->name('cart.store');
Route::delete('/cart', 'CartController@destroy')->name('cart.destroy');

Route::resource('/reviews', 'ReviewController')->only(['store', 'destroy']);

Route::resource('/products', 'ProductController');

Route::resource('/orders', 'OrderController')->only(['index', 'show', 'store']);



