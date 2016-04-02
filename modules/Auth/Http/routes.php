<?php

Route::group(['prefix' => 'auth', 'namespace' => 'Modules\Auth\Http\Controllers'], function()
{
	Route::get('/', 'AuthController@index');
});