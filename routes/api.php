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

/**
 * API KEY GENERATOR
 */
Route::get('randApiKey', function() { $apikey = ''; $key_a = ''; $key_b = ''; $chars = ''; $char = 'abcdefghiklmnopqrstvxyzABCDEFGHIKLMNOPQRSTVXYZ'; for ($i=0; $i < 3; $i++) { $chars .= $char[rand(0,45)]; $chars .= md5($chars); } $key_a = md5($chars); $key_b = $chars.time(); $key_b = md5($key_b); $apikey = $key_b.$key_a.md5($key_a.$key_b); print_r($apikey); });


/**
 * AUTH
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('details', 'Api\UserController@details');
    Route::get('all-users', 'Api\UserController@getAllUsers');
});


/** 
 * PAGES 
 */
Route::group(['middleware' => ['auth:api']], function() {
});

Route::get('pages/{id}/key/{key}', 'Api\PagesController@getPage');

Route::get('pages/key/{key}', 'Api\PagesController@getPagesList');

Route::put('pages/{id}/set-visible/key/{key}', 'Api\PagesController@setPageVisible');

Route::put('pages/{id}/set-invisible/key/{key}', 'Api\PagesController@setPageInvisible');

Route::post('pages/{id}/update-content/key/{key}', 'Api\PagesController@updateContent');

Route::post('pages/add/key/{key}', 'Api\PagesController@addPage');

Route::delete('pages/{id}/delete/key/{key}', 'Api\PagesController@deletePage');


