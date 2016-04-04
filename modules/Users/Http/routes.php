<?php

Route::group(['prefix' => 'users', 'namespace' => 'Modules\Users\Http\Controllers'], function()
{
	Route::get('/', function () {
		return redirect()->route('user.login');
	});
	Route::get('login', ['uses' => 'UsersController@index', 'as' => 'user.login']);
	Route::get('register', ['uses' => 'UsersController@register', 'as' => 'user.register']);
	Route::post('register', ['uses' => 'UsersController@postRegister', 'as' => 'user.post.register']);
	Route::post('login', ['uses' => 'UsersController@postLogin', 'as' => 'user.post.login']);

	Route::group(['middleware' => 'sentinel.auth'], function () {
		Route::get('logout', ['uses' => 'UsersController@logout', 'as' => 'user.logout']);
		Route::get('change', ['uses' => 'UsersController@changepass', 'as' => 'user.changepass']);
		Route::get('profile', ['uses' => 'UsersController@profile', 'as' => 'user.profile']);

		Route::post('change', ['uses' => 'UsersController@updatepass', 'as' => 'user.post.changepass']);
	});
	
});