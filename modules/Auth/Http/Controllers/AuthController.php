<?php namespace Modules\Auth\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class AuthController extends Controller {
	
	public function index()
	{
		return view('Auth::index');
	}
	
}