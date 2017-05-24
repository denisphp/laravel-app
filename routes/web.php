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

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    // ADMIN
    Route::get('admin/login', 'Admin\Auth\LoginController@getLogin');
    Route::post('admin/authenticate', 'Admin\Auth\LoginController@postLogin');
});

Route::group(['middleware' => ['admin']], function () {
    Route::get('admin/dashboard', 'Admin\AdminController@dashboard');
    Route::get('admin/logout', 'Admin\Auth\LoginController@logout');
});