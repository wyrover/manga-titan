<?php namespace Modules\Users\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Modules\Users\Http\Requests\LoginReq;
use Modules\Users\Http\Requests\RegisterReq;
use Sentinel;

class UsersController extends Controller {
	
	public $redirect_to = 'manga';

	public function index(){
		return view('users::login');
	}
	public function register() {
		return view('users::register');
	}
	public function postRegister(Request $r) {
		$creds = $r->only(['email','password']);
		$names = explode(' ',$r->input('name'));
		$first_name = array_shift($names);
		if (count($names) > 0)
			$creds['last_name'] = implode(' ',$names);
		
		$creds['first_name'] = $first_name;
		
		try {
			if (Sentinel::register($creds)) {
				return redirect()->route('user.register')->with('message', 'Success register user, wait for a day to verify your account');
			} else {
				return redirect()->back()->withErrors(['Cant register this user']);
			}
		} catch (QueryException $e) {
			return redirect()->back()->withErrors(['this user already register']);
		}
		
	}
	public function postLogin(LoginReq $r) {
		$creds = $r->except(['remember_me','_token']);
		$remember = $r->input('remember_me') == 'on' ? true : false;
		
		if ($user = Sentinel::authenticate($creds, $remember)) {
			return redirect($this->redirect_to);
		} else {
			return redirect()->back()->withErrors(['Your password or email wrong!']);
		}
	}
	
}