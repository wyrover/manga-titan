<?php
namespace Modules\Core\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Core\Http\Controllers\Iface\AjaxResponse;
use Modules\Core\Entities\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller implements AjaxResponse {
	
	public static function getData($data) {
		$resdata = [];$coldata = [];
		$page_num = (array_key_exists('page_num', $data) && intval($data['page_num']) > 0)?intval($data['page_num']):1;

		$category = Category::orderBy('category')->get();
		$max_page = ceil($category->count()/20);
		$category = $category->forPage($page_num, 20);

		foreach ($category as $cate) {
			$coldata[] = [
				'id' => $cate->id,
				'category' => $cate->category,
				'desc' => $cate->description,
				'thumb' => $cate->thumb_path,
				'used' => $cate->manga->count()
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
			if ($data['id'] == '') {
				$category = new Category;
			} else {
				$category = Category::findOrFail($data['id']);
			}
			$category->category = $data['category'];
			$category->description = $data['desc'];
			$category->thumb_path = $data['thumb'];
			$category->save();

			$result['message'] = 'Success Save Data';
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
			Category::destroy($data['id']);
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
		$category = Category::all();
		$datacol = [];
		foreach ($category as $cate) {
			$datacol[] = [
				'value' => $cate->id,
				'text' => $cate->category
			];
		}
		return ['data' => $datacol, 'message' => 'source category', 'success' => true];
	}

}