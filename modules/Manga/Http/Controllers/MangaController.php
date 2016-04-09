<?php
namespace Modules\Manga\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Sentinel;
use Modules\Manga\Http\Controllers\Traitajax\TraitManga;

class MangaController extends Controller {

	use TraitManga;
	
	public function index()
	{
		return view('manga::home');
	}
	
	public function category()
	{
		return view('manga::category');
	}

	public function tags()
	{
		return view('manga::tags');
	}

	public function newest()
	{
		return view('manga::newest');
	}

	public function favorite()
	{
		return view('manga::favorite');
	}

	public function desc($id_manga)
	{
		$manga = $this->getMangaDesc($id_manga);
		return view('manga::description', ['manga' => $manga]);
	}

	public function read($id_manga, $page = 1)
	{
		$manga = $this->getMangaDesc($id_manga);
		return view('manga::read', ['manga' => $manga, 'page' => $page]);
	}
}