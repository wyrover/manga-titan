<?php
namespace Modules\Manga\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Sentinel;

class MangaController extends Controller {
	
	public function index()
	{
		return view('manga::index');
	}
	
}