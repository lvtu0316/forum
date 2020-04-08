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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads','ThreadsController@index')->name('threads.index');
Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('/threads/{channel}','ThreadsController@index')->name('threads.channel');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');
Route::post('/threads','ThreadsController@store')->name('threads.store');
Route::post('/threads/{thread}', 'ThreadsController@destroy')->name('threads.delete');
Route::get('/threads/{thread}/edit', 'threadsController@edit')->name('threads.edit');
Route::patch('/threads/{thread}', 'threadsController@update')->name('threads.update');
Route::delete('/threads/{thread}', 'threadsController@destroy')->name('threads.destroy');

Route::get('/threads/{channel}/{thread}/replies','RepliesController@index')->name('reply.index');
Route::post('/threads/{thread}/replies','RepliesController@store')->name('reply.store');
Route::delete('/replies/{reply}','RepliesController@destroy')->name('reply.delete');
Route::patch('/replies/{reply}','RepliesController@update')->name('reply.update');

Route::post('/replies/{reply}/favorite','FavoritesController@store')->name('favorite.store');
Route::delete('/replies/{reply}/favorite','FavoritesController@destroy')->name('favorite.delete');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile.show');