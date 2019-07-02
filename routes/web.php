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

Route::get('/', 'WeatherController@index')->name('weather');
Route::get('/orders', 'OrderController@index')->name('orders.index');
Route::get('/orders/{orderId}/edit', 'OrderController@edit')->where(['orderId' => '[0-9]+'])->name('orders.edit');
Route::put('/orders/{orderId}', 'OrderController@update')->where(['orderId' => '[0-9]+'])->name('orders.update');