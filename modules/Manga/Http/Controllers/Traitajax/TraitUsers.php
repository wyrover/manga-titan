<?php

namespace Modules\Manga\Http\Controllers\Traitajax;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Manga\Entities\Users;
use File;
use Sentinel;
use Activation;

trait TraitUsers {
	public function getUsers($page_num) {
		if ($page_num == null) $page_num = 1;
		$result = ['message' => '', 'success' => false];

		$users = Users::all();
		$max_page = ceil($users->count() / 10);

		$users = $users->forPage($page_num, 10);
		$data = [];
		foreach ($users as $user) {
			$sentinel_user = Sentinel::findById($user->id);
			$activation = Activation::completed($sentinel_user);
			$data[] = [
				'id' => $sentinel_user->id,
				'email' => $sentinel_user->email,
				'completed' => ($activation!=false)?'<i class="icon green checkmark"></i>':'<i class="icon red remove"></i>',
				'is_active' => ($activation!=false)?true:false,
				'created_at' => $sentinel_user->created_at->diffForHumans()
			];
		}

		$result['data'] = ['data' => $data, 'page_num' => $page_num, 'max_page' => $max_page];
		$result['message'] = 'Success get users';
		$result['success'] = true;

		return $result;
	}
	public function saveUser($data) {
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
	public function deleteUser($data) {
		$result = ['message' => '', 'success' => false];
		try {
			if (is_array($data['id'])) {
				foreach ($data['id'] as $id) {
					Sentinel::findById($id)->delete();
				}
			} else {
				$user = Sentinel::findById($data['id']);
				$user->delete();
			}
			$result['message'] = 'Success delete user';
			$result['success'] = true;
		} catch (ModelNotFoundException $e) {
			$result['message'] = $e->getMessage();
			$result['success'] = false;
		}
		return $result;
	}
}