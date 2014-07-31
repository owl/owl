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

/*
 * Dont Need Login.
 */
Route::get('login', array('uses' => 'LoginController@login'));
Route::post('login', array('uses' => 'LoginController@auth'));
Route::get('signup', array('uses' => 'SignupController@signup'));
Route::post('signup', array('uses' => 'SignupController@register'));

/*
 * Need Login.
 */
Route::group(array('before' => 'sentry'), function() {
    // Basic
    Route::get('/', array('uses' => 'IndexController@index'));
    Route::get('logout', array('uses' => 'LogoutController@logout'));

    // Users
    Route::get('user/edit', array('uses' => 'UserController@edit'));
    Route::put('user/edit', array('uses' => 'UserController@update'));
    Route::get('user/stock', array('uses' => 'UserController@stock'));
    Route::get('user/{username}', array('uses' => 'UserController@show'));

    // Items
    Route::resource('items', 'ItemController');
});

