<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('language', 'PostController@language');

Route::get('home', 'HomeController@index');

Route::resource('user', 'UserController');

Route::resource('post', 'PostController', ['except' => ['show', 'edit', 'update']]);

Route::get('post/tag/{tag}', 'PostController@indexTag');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);