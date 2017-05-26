<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api'], 'prefix' => 'v1'], function () {
    Route::post('register', 'V1\Auth\RegisterController@register');
    Route::post('login', 'V1\Auth\LoginController@login');
    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('user/profile', 'V1\User\UserController@showProfile');
    });
});

