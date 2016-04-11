<?php

namespace Modules\Manga\Http\Controllers\Traitajax;

use Modules\Manga\Entities\Users;
use File;

trait TraitUsers {
	public function getUsers($page_num) {
		if ($page_num == null) $page_num = 1;
		$result = ['message' => '', 'success' => false];

		$users = Users::all();
		$max_page = ceil($users->count() / 10);

		$users = $users->forPage($page_num, 10);
		$data = [];
		foreach ($users as $user) {
			$data[] = [
				'id' => $user->id,
				'email' => $user->email,
				'completed' => $user->activation->completed,
				'is_active' => ($user->activation->completed)?'<i class="icon green checkmark"></i>':'<i class="icon red remove"></i>',
				'created_at' => $user->created_at->diffForHumans()
			];
		}

		$result['data'] = ['data' => $data, 'page_num' => $page_num, 'max_page' => $max_page];
		$result['message'] = 'Success get users';
		$result['success'] = true;

		return $result;
	}
}