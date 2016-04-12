<?php
namespace Modules\Core\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Core\Http\Controllers\Iface\AjaxResponse;

class CategoryController extends Controller implements AjaxResponse {
	
	public static function getData($data) {
		return ['data' => [], 'message' => 'success', 'success' => true];
	}

	public static function saveData($data) {
		//
	}
	
	public static function deleteData($data) {
		//
	}

	public static function detailData($data) {
		//
	}

}