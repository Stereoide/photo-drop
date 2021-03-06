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

Route::get('/', 'LoginController@index')->name('index');
Route::get('login/external/{token}', 'LoginController@prefill');
Route::resource('login', 'LoginController');

Route::resource('logout', 'LogoutController');

Route::resource('photos', 'PhotosController');
