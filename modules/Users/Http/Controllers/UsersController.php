<?php namespace Modules\Users\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Modules\Users\Http\Requests\LoginReq;
use Modules\Users\Http\Requests\RegisterReq;
use Modules\Users\Http\Requests\PasswordReq;
use Sentinel;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class UsersController extends Controller {
	
	public $redirect_to = 'manga';

	public function redirect() {
		return redirect()->route('user.login');
	}

	public function index(){
		return view('users::login');
	}
	public function register() {
		return view('users::register');
	}
	public function postRegister(RegisterReq $r) {
		$creds = $r->only(['email','password']);
		
		$names = explode(' ',$r->input('name'));
		$first_name = array_shift($names);

		if (count($names) > 0)
			$creds['last_name'] = implode(' ',$names);
		
		$creds['first_name'] = $first_name;
		
		try {
			if (Sentinel::register($creds)) 
				return redirect()->route('user.register')->with('message', 'Success register user, wait for a day to verify your account');
			
			return redirect()->back()->withErrors(['Cant register this user']);

		} catch (QueryException $e) {

			return redirect()->back()->withErrors(['This user already register']);

		}
	}
	public function postLogin(LoginReq $r) {
		$creds = $r->except(['remember_me','_token']);
		$remember = $r->input('remember_me') == 'on' ? true : false;
		
		try {
			if ($user = Sentinel::authenticate($creds, $remember))
				return redirect($this->redirect_to);

			return redirect()->back()->withErrors(['Your password or email wrong!']);

		} catch (NotActivatedException $e) {

			return redirect()->back()->withErrors(['Your account has not been activated yet']);

		}
	}

	public function logout() {
		$user = Sentinel::getUser();
		Sentinel::logout($user, true);

		return redirect()->route('user.login');
	}
	public function changepass() {
		return view('users::changepass');
	}

	public function updatepass(PasswordReq $r) {
		$hasher = Sentinel::getHasher();

		$old_pass = $r->input('current_password');
		$new_pass = $r->input('password');

		$user = Sentinel::getUser();

		if (! $hasher->check($old_pass, $user->password)) {
			return redirect()->back()->withErrors(['Your Password Incorrect']);
		}

		Sentinel::update($user, ['password' => $new_pass]);

		return redirect()->route('user.changepass')->with('message', 'Success change your password. Please logout and login with new password.');
	}
	
}