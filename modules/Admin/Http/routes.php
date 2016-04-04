<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
	Route::get('/', ['uses' => 'AdminController@index', 'as' => 'admin.home']);
});