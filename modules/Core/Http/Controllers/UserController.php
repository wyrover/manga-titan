<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Pingpong\Modules\Routing\Controller;
use Modules\Core\Http\Controllers\Iface\AjaxResponse;
use Modules\Core\Entities\Users;
use Sentinel;
use Activation;

class UserController extends Controller implements AjaxResponse {
	
	public static function getData($data) {
		$resdata = [];$coldata = [];
		$page_num = (array_key_exists('page_num', $data) && intval($data['page_num']) > 0)?intval($data['page_num']):1;

		$users = Users::all();
		$max_page = ceil($users->count() / 10);
		$users = $users->forPage($page_num, 10);

		foreach ($users as $user) {
			$activation = Activation::completed($user);
			$coldata[] = [
				'id' => $user->id,
				'email' => $user->email,
				'completed' => ($activation!=false)?'<i class="icon green checkmark"></i>':'<i class="icon red remove"></i>',
				'is_active' => ($activation!=false)?true:false,
				'created_at' => $user->created_at->diffForHumans()
			];
		}
		$resdata = [
			'data' => $coldata,
			'max_page' => $max_page,
			'page_num' => $page_num
		];
		return ['data' => $resdata, 'message' => 'success', 'success' => true];
	}

	public static function saveData($data) {
		$result = ['message' => '', 'success' => false];
		try {
			$data['is_active'] = isset($data['is_active'])? $data['is_active'] : 'off';
			if ($data['id'] == '') {
				$credentials = ['email' => $data['email'], 'password' => $data['password']];
				if (Sentinel::validForCreation($credentials)) {
					if ($data['is_active'] == 'on')
						$user = Sentinel::registerAndActivate($credentials);
					else
						$user = Sentinel::register($credentials);
				}
			} else {
				$credentials = ['email' => $data['email']];
				$user = Sentinel::findById($data['id']);
				Sentinel::update($user, $credentials);
				if ($data['is_active'] == 'on' && ! Activation::exists($user)) {
					$activate = Activation::create($user);
					Activation::complete($user, $activate->code);
				}
			}
			$result['data'] = $user;
			$result['message'] = "Success save user";
			$result['success'] = true;
		} catch (ModelNotFoundException $e) {
			$result['message'] = $e->getMessage();
			$result['success'] = false;
		}
		return $result;
	}
	
	public static function deleteData($data) {
		$result = ['message' => '', 'success' => false];
		try {
			Users::destroy($data['id']);
			$result['message'] = 'Success delete user';
			$result['success'] = true;
		} catch (ModelNotFoundException $e) {
			$result['message'] = $e->getMessage();
			$result['success'] = false;
		}
		return $result;
	}

	public static function detailData($data) {
		//
	}
	
}