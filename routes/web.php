<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    if ($user_id = Auth::id())
    {
      return redirect('/snippets');
    }
    else
    {
      return view('welcome');
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::resource('/snippets', 'SnippetsController');

Route::get('/user', 'UsersController@edit')->middleware('auth');
Route::put('/user', 'UsersController@update')->middleware('auth');
