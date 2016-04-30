<?php

/**
 * @copyright (c) owl
 */

/**
 * Not Logged In.
 */
Route::group(['middleware' => 'notLogin'], function () {
    Route::get('login',                  ['uses' => 'AuthController@login',      'as' => 'login.form']);
    Route::post('login',                 ['uses' => 'AuthController@attempt',    'as' => 'login']);
    Route::get('signup',                 ['uses' => 'UserController@signup',     'as' => 'signup.form']);
    Route::post('signup',                ['uses' => 'UserController@register',   'as' => 'signup']);
    Route::get('password/reminder',      ['uses' => 'ReminderController@remind', 'as' => 'password.reminder.form']);
    Route::post('password/reminder',     ['uses' => 'ReminderController@send',   'as' => 'password.reminder']);
    Route::get('password/reset/{token}', ['uses' => 'ReminderController@edit',   'as' => 'password.reset.form']);
    Route::post('password/reset',        ['uses' => 'ReminderController@update', 'as' => 'password.reset']);
});

/*
 * Dont Need Login.
 */
Route::get('search',       ['uses' => 'SearchController@index', 'as' => 'search']);
Route::get('search/json',  ['uses' => 'SearchController@json',  'as' => 'search.json']);
Route::get('search/jsonp', ['uses' => 'SearchController@jsonp', 'as' => 'search.jsonp']);
Route::get('tags/suggest', ['uses' => 'TagController@suggest',  'as' => 'tag.suggest']);

/*
 * Need Login and Role is Owner
 */
Route::group(['middleware' => ['login', 'owner']], function () {
    Route::get('manage',                            ['uses' => 'AdminController@index',     'as' => 'admin']);
    Route::get('manage/user/index',                 ['uses' => 'UserController@index',      'as' => 'user.show']);
    Route::post('manage/user/{user_id}/roleUpdate', ['uses' => 'UserController@roleUpdate', 'as' => 'role.update']);
    Route::get('manage/flow/index',                 ['uses' => 'FlowTagController@index',   'as' => 'flow.show']);
    Route::post('manage/flow/store',                ['uses' => 'FlowTagController@store',   'as' => 'flow.add']);
    Route::delete('manage/flow/destroy',            ['uses' => 'FlowTagController@destroy', 'as' => 'flow.destroy']);
});

/*
 * Need Login.
 */
Route::group(['middleware' => 'login'], function () {
    // Basic
    Route::get('/',      ['uses' => 'IndexController@index', 'as' => 'index']);
    Route::get('logout', ['uses' => 'AuthController@logout', 'as' => 'logout']);

    // Items
    Route::get('items',                 ['uses' => 'ItemController@index',   'as' => 'items.index']);
    Route::get('items/create',          ['uses' => 'ItemController@create',  'as' => 'items.create']);
    Route::post('items',                ['uses' => 'ItemController@store',   'as' => 'items.store']);
    Route::get('items/{items}/edit',    ['uses' => 'ItemController@edit',    'as' => 'items.edit']);
    Route::get('items/{items}/history', ['uses' => 'ItemController@history', 'as' => 'items.history']);
    Route::put('items/{items}',         ['uses' => 'ItemController@update',  'as' => 'items.update']);
    Route::delete('items/{items}',      ['uses' => 'ItemController@destroy', 'as' => 'items.destroy']);
    Route::post('items/parse',          ['uses' => 'ItemController@parse',   'as' => 'items.parse']);
    Route::resource('templates', 'TemplateController');
    Route::resource('favorites', 'StockController');
    Route::resource('likes', 'LikeController');

    // Tags
    Route::get('tags',        ['uses' => 'TagController@index', 'as' => 'tags.index']);
    Route::get('tags/{tags}', ['uses' => 'TagController@show',  'as' => 'tags.show']);

    // Users
    Route::get('user/edit',      ['uses' => 'UserController@edit',     'as' => 'user.edit.form']);
    Route::put('user/edit',      ['uses' => 'UserController@update',   'as' => 'user.update' ]);
    Route::post('user/password', ['uses' => 'UserController@password', 'as' => 'password.update']);
    Route::get('/{username}',    ['uses' => 'UserController@show',     'as' => 'user.profile']);

    // User Roles
    Route::get('user/role/initial',  ['uses' => 'UserRoleController@initial',         'as' => 'role.initial']);
    Route::post('user/role/initial', ['uses' => 'UserRoleController@initialRegister', 'as' => 'owner.create']);

    Route::post('image/upload',    ['uses' => 'ImageController@upload',    'as' => 'image.upoad']);
    Route::post('comment/create',  ['uses' => 'CommentController@create',  'as' => 'comment.create']);
    Route::post('comment/destroy', ['uses' => 'CommentController@destroy', 'as' => 'comment.destroy']);
    Route::post('comment/update',  ['uses' => 'CommentController@update',  'as' => 'comment.update']);

    // User Mail Notification Settings
    Route::post('user/notification/update', ['uses' => 'MailNotifyController@update', 'as' => 'user.notification.update']);
});

/*
 * Dont Need Login. (must write after items/***)
 */
Route::get('items/{items}', ['uses' => 'ItemController@show', 'as' => 'items.show']);
