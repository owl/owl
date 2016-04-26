<?php

/**
 * @copyright (c) owl
 */

/**
 * Not Logged In.
 */
Route::group(['middleware' => 'notLogin'], function () {
    Route::get('login',                  array('uses' => 'AuthController@login',      'as' => 'login.form'));
    Route::post('login',                 array('uses' => 'AuthController@attempt',    'as' => 'login'));
    Route::get('signup',                 array('uses' => 'UserController@signup',     'as' => 'signup.form'));
    Route::post('signup',                array('uses' => 'UserController@register',   'as' => 'signup'));
    Route::get('password/reminder',      array('uses' => 'ReminderController@remind', 'as' => 'password.reminder.form'));
    Route::post('password/reminder',     array('uses' => 'ReminderController@send',   'as' => 'password.reminder'));
    Route::get('password/reset/{token}', array('uses' => 'ReminderController@edit',   'as' => 'password.reset.form'));
    Route::post('password/reset',        array('uses' => 'ReminderController@update', 'as' => 'password.reset'));
});

/*
 * Dont Need Login.
 */
Route::get('search',       array('uses' => 'SearchController@index', 'as' => 'search'));
Route::get('search/json',  array('uses' => 'SearchController@json',  'as' => 'search.json'));
Route::get('search/jsonp', array('uses' => 'SearchController@jsonp', 'as' => 'search.jsonp'));
Route::get('tags/suggest', array('uses' => 'TagController@suggest',  'as' => 'tag.suggest'));

/*
 * Need Login and Role is Owner
 */
Route::group(['middleware' => ['login', 'owner']], function () {
    Route::get('manage',                            array('uses' => 'AdminController@index',     'as' => 'admin'));
    Route::get('manage/user/index',                 array('uses' => 'UserController@index',      'as' => 'user.show'));
    Route::post('manage/user/{user_id}/roleUpdate', array('uses' => 'UserController@roleUpdate', 'as' => 'role.update'));
    Route::get('manage/flow/index',                 array('uses' => 'FlowTagController@index',   'as' => 'flow.show'));
    Route::post('manage/flow/store',                array('uses' => 'FlowTagController@store',   'as' => 'flow.add'));
    Route::delete('manage/flow/destroy',            array('uses' => 'FlowTagController@destroy', 'as' => 'flow.destroy'));
});

/*
 * Need Login.
 */
Route::group(['middleware' => 'login'], function () {
    // Basic
    Route::get('/',      array('uses' => 'IndexController@index', 'as' => 'index'));
    Route::get('logout', array('uses' => 'AuthController@logout', 'as' => 'logout'));

    // Items
    Route::get('items',                 array('uses' => 'ItemController@index',   'as' => 'items.index'));
    Route::get('items/create',          array('uses' => 'ItemController@create',  'as' => 'items.create'));
    Route::post('items',                array('uses' => 'ItemController@store',   'as' => 'items.store'));
    Route::get('items/{items}/edit',    array('uses' => 'ItemController@edit',    'as' => 'items.edit'));
    Route::get('items/{items}/history', array('uses' => 'ItemController@history', 'as' => 'items.history'));
    Route::put('items/{items}',         array('uses' => 'ItemController@update',  'as' => 'items.update'));
    Route::delete('items/{items}',      array('uses' => 'ItemController@destroy', 'as' => 'items.destroy'));
    Route::post('items/parse',          array('uses' => 'ItemController@parse',   'as' => 'items.parse'));
    Route::resource('templates', 'TemplateController');
    Route::resource('favorites', 'StockController');
    Route::resource('likes', 'LikeController');

    // Tags
    Route::get('tags',        array('uses' => 'TagController@index', 'as' => 'tags.index'));
    Route::get('tags/{tags}', array('uses' => 'TagController@show',  'as' => 'tags.show'));

    // Users
    Route::get('user/edit',      array('uses' => 'UserController@edit',     'as' => 'user.edit.form'));
    Route::put('user/edit',      array('uses' => 'UserController@update',   'as' => 'user.update' ));
    Route::post('user/password', array('uses' => 'UserController@password', 'as' => 'password.update'));
    Route::get('/{username}',    array('uses' => 'UserController@show',     'as' => 'user.profile'));

    // User Roles
    Route::get('user/role/initial',  array('uses' => 'UserRoleController@initial',         'as' => 'role.initial'));
    Route::post('user/role/initial', array('uses' => 'UserRoleController@initialRegister', 'as' => 'owner.create'));

    Route::post('image/upload',    array('uses' => 'ImageController@upload',    'as' => 'image.upoad'));
    Route::post('comment/create',  array('uses' => 'CommentController@create',  'as' => 'comment.create'));
    Route::post('comment/destroy', array('uses' => 'CommentController@destroy', 'as' => 'comment.destroy'));
    Route::post('comment/update',  array('uses' => 'CommentController@update',  'as' => 'comment.update'));

    // User Mail Notification Settings
    Route::post('user/notification/update', array('uses' => 'MailNotifyController@update', 'as' => 'user.notification.update'));
});

/*
 * Dont Need Login. (must write after items/***)
 */
Route::get('items/{items}', array('uses' => 'ItemController@show', 'as' => 'items.show'));
