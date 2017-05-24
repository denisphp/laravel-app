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
    Route::get('admin', 'Admin\AdminController@index');
    Route::get('admin/logout', 'Admin\Auth\LoginController@logout');
    Route::get('admin/users', 'Admin\UserController@index');
    Route::get('admin/users/{id}', 'Admin\UserController@view')->where('id', '[0-9]+');
    Route::get('admin/users/{id}/edit', 'Admin\UserController@edit')->where('id', '[0-9]+');
    Route::post('admin/users/{id}/update', 'Admin\UserController@update')->where('id', '[0-9]+')->name('admin.users.update');
});