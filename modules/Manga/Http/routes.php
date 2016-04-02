<?php

Route::group(['prefix' => 'manga', 'namespace' => 'Modules\Manga\Http\Controllers', 'middleware' => 'sentinel.auth'], function()
{
	Route::get('/', 'MangaController@index');
});