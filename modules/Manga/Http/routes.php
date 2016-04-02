<?php

Route::group(['prefix' => 'manga', 'namespace' => 'Modules\Manga\Http\Controllers'], function()
{
	Route::get('/', 'MangaController@index');
});