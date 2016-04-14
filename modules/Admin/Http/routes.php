<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers', 'middleware' => 'sentinel.admin'], function()
{
	Route::get('/', ['uses' => 'AdminController@index', 'as' => 'admin.home']);
	Route::get('manga', ['uses' => 'AdminController@manga', 'as' => 'admin.manga']);
	Route::get('page/{id_manga}', ['uses' => 'AdminController@page', 'as' => 'admin.page']);
	Route::get('tag', ['uses' => 'AdminController@tag', 'as' => 'admin.tag']);
	Route::get('category', ['uses' => 'AdminController@category', 'as' => 'admin.category']);
	Route::get('comment', ['uses' => 'AdminController@comment', 'as' => 'admin.comment']);
	Route::get('user', ['uses' => 'AdminController@user', 'as' => 'admin.user']);
});