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

// Index
Route::get('/', function () {
    if (Auth::user())
    {
      return redirect('/snippets');
    }
    else
    {
      return view('welcome');
    }
});

// Home
Route::get('/home', 'HomeController@index');

// Auth routes
Auth::routes();
Route::get('/auth/google', 'Auth\SocialAuthController@redirectToProvider');
Route::get('/auth/google/callback', 'Auth\SocialAuthController@handleProviderCallback');

// Snippets
Route::resource('/snippets', 'SnippetsController');

// Users
Route::get('/user', 'UsersController@edit')->middleware('auth');
Route::put('/users/{user}', 'UsersController@update')->middleware('auth');
Route::delete('/users/{user}', 'UsersController@destroy');

// Admin
Route::group(['middleware'=>'check_admin'], function() {
  Route::get('/admin/snippets', 'AdminController@snippet_index');
  Route::get('/admin/users', 'AdminController@user_index');
  Route::get('/admin/users/{user}', 'AdminController@user_edit');
});
