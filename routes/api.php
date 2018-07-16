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

Route::apiResources([
	'post'=>'Api\PostController',
]);

Route::group(['prefix'=>'category'], function() {
	Route::get('index','Api\CategoryController@index');
	Route::get('show/{id}','Api\CategoryController@show');
	Route::post('store','Api\CategoryController@store');
	Route::post('update/{id}','Api\CategoryController@update');
	Route::post('destroy/{id}','Api\CategoryController@destroy');
	Route::post('search','Api\CategoryController@search');
});