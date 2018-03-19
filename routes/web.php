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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/','PostController@paginate')->name('post.paginate');
Route::get('detail/{id}','PostController@detail')->name('post.detail');
Route::get('category/{id}','CategoryController@percategory')->name('category.per');

Auth::routes();

Route::group(['prefix'=>'back','middleware'=>'auth'],function() {
	Route::get('/','PostController@search')->name('post.search');

	Route::get('dashboard', 'HomeController@index')->name('home');

	Route::post('pertahun','HomeController@pertahun')->name('chart.pertahun');
	Route::post('perbulan','HomeController@perbulan')->name('chart.perbulan');
	
	Route::resource('post','PostController');
	Route::patch('verification/{id}','PostController@verification')->name('post.verification')->middleware('chief');
	Route::patch('revision/{id}','PostController@revision')->name('post.revision')->middleware('chief');
	Route::patch('approval/{id}','PostController@approval')->name('post.approval')->middleware('leader');

	Route::resource('category','CategoryController')->middleware('leader','chief');
	Route::resource('comment','CommentController');

	Route::get('user/{id}/edit','UserController@edit')->name('user.edit');
	Route::patch('user/{id}','UserController@update')->name('user.update');

	Route::get('getpost','PostController@getpost')->name('data.post');
	Route::get('getcategory','CategoryController@getcategory')->name('data.category');
	Route::get('getcomment','CommentController@getcomment')->name('data.comment');

	Route::get('export','ExportController@post')->name('export.excel');
});