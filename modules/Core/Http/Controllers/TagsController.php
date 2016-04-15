<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Pingpong\Modules\Routing\Controller;
use Modules\Core\Http\Controllers\Iface\AjaxResponse;
use Modules\Core\Entities\Manga;

class TagsController extends Controller implements AjaxResponse {
	
	public static function getData($data) {
		//
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

	public static function sourceData($data) {
		$tags = Manga::allTags()->get();
		$datacol = [];
		foreach ($tags as $tag) {
			$datacol[] = [
				'value' => $tag->name,
				'text' => $tag->name
			];
		}
		return ['data' => $datacol, 'message' => 'source tags', 'success' => true];
	}
	
}