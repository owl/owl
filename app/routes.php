<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
 */
Route::get('/', array('before' => 'sentry', 'uses' => 'IndexController@index'));

Route::get('/items/show/{item_id}', 'ItemController@show');
Route::get('/items/create', 'ItemController@create');



Route::controller('items', 'ItemController');
Route::controller('login', 'LoginController');
Route::controller('logout', 'LogoutController');
Route::controller('signup', 'SignupController');
