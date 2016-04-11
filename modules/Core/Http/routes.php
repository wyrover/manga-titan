<?php

Route::group(['prefix' => 'core', 'namespace' => 'Modules\Core\Http\Controllers', 'middleware' => 'sentinel.auth'], function()
{
	Route::post('ajax', ['as' => 'core.ajax', 'uses' => 'CoreController@ajaxProcessor']);
});