<?php
namespace Modules\Manga\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Sentinel;

class MangaController extends Controller {
	
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
}