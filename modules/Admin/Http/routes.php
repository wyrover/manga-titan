<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers', 'middleware' => 'sentinel.auth'], function()
{
	Route::get('/', ['uses' => 'AdminController@index', 'as' => 'admin.home']);
	Route::get('manga', ['uses' => 'AdminController@manga', 'as' => 'admin.manga']);
	Route::get('tag', ['uses' => 'AdminController@tag', 'as' => 'admin.tag']);
	Route::get('category', ['uses' => 'AdminController@category', 'as' => 'admin.category']);
	Route::get('comment', ['uses' => 'AdminController@comment', 'as' => 'admin.comment']);
	Route::get('user', ['uses' => 'AdminController@user', 'as' => 'admin.user']);
});