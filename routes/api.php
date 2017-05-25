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

Route::group(['middleware' => ['api']], function () {
    Route::post('register', 'APIController@register');
    Route::post('login', 'APIController@login');
    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('get_user_details', 'APIController@get_user_details');
    });
});

