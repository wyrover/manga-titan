<?php namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class AdminController extends Controller {
	
	public function index()
	{
		return view('admin::home');
	}
	
	public function manga()
	{
		return view('admin::manga');
	}

	public function page($id_manga)
	{
		return view('admin::page', ['id_manga' => $id_manga]);
	}

	public function tag()
	{
		return view('admin::tag');
	}

	public function category()
	{
		return view('admin::category');
	}

	public function comment()
	{
		return view('admin::comment');
	}

	public function user()
	{
		return view('admin::user');
	}
}