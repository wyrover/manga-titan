<?php namespace Modules\Manga\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class MangaController extends Controller {
	
	public function index()
	{
		return view('Manga::index');
	}
	
}