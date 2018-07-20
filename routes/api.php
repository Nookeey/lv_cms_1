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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::group(['middleware' => ['cors']], function() {
    Route::post('login', 'Api\UserController@login');
    Route::post('register', 'Api\UserController@register');
// });
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('details', 'Api\UserController@details');
    Route::get('all-users', 'Api\UserController@getAllUsers');
});


/** 
 * PAGES 
 */
Route::group(['middleware' => ['auth:api']], function() {
    Route::post('pages/add', 'Api\PagesController@addPage');
    Route::put('pages/set-invisible/{id}', 'Api\PagesController@setPageInvisible');
    Route::put('pages/set-visible/{id}', 'Api\PagesController@setPageVisible');
    Route::delete('pages/delete/{id}', 'Api\PagesController@deletePage');
    Route::post('pages/update-content/{id}', 'Api\PagesController@updateContent');
});
// Route::group(['middleware' => ['cors']], function() {
    Route::get('pages/{id}', 'Api\PagesController@getPage');
    Route::get('pages', 'Api\PagesController@getPagesList');
// });


