<?php

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

Route::group(['middleware' => 'auth:api'], function(){
	Route::get('/users', 'UserController@index');
	Route::get('/users/{id}', 'UserController@show');
	Route::get('/me', 'UserController@me');
});

Route::post('/users', 'UserController@store');
Route::post('/login', 'AuthController@login');