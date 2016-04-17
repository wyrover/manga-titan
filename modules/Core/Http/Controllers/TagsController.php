<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Pingpong\Modules\Routing\Controller;
use Modules\Core\Http\Controllers\Iface\AjaxResponse;
use Modules\Core\Entities\Manga;
use Modules\Core\Entities\Tag;

class TagsController extends Controller implements AjaxResponse {
	
	public static function getData($data) {
		$resdata = [];$coldata = [];
		$page_num = (array_key_exists('page_num', $data) && intval($data['page_num']) > 0)?intval($data['page_num']):1;

		$tags = Manga::allTags()->get();
		$max_page = ceil($tags->count()/20);
		$tags = $tags->forPage($page_num, 20);

		foreach ($tags as $tag) {
			$coldata[] = [
				'id' => $tag->id,
				'tag' => $tag->name,
				'used' => $tag->count
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
		//
	}
	
	public static function deleteData($data) {
		$result = ['message' => '', 'success' => false];
		try {
			if (is_array($data['id'])) {
				foreach ($data['id'] as $id) {
					Tag::findOrFail($id)->delete();
				}
			} else {
				Tag::findOrFail($data['id'])->delete();
			}
			$result['message'] = 'Success Delete data';
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