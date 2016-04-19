<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Pingpong\Modules\Routing\Controller;
use Modules\Core\Http\Controllers\Iface\AjaxResponse;
use Modules\Core\Entities\Manga;
use Modules\Core\Entities\Category;
use Sentinel;

class MangaController extends Controller implements AjaxResponse {
	
	public static function getData($data) {
		$resdata = [];$coldata = [];
		$page_num = (array_key_exists('page_num', $data) && intval($data['page_num']) > 0)?intval($data['page_num']):1;

		$manga = Manga::orderBy('created_at')->get();
		$max_page = ceil($manga->count()/20);
		$manga = $manga->forPage($page_num, 20);

		foreach ($manga as $mang) {
			$coldata[] = [
				'id' => $mang->id,
				'title' => $mang->title,
				'page' => $mang->mangapages->count(),
				'description' => $mang->description,
				'category' => $mang->category->id,
				'tags' => $mang->getTagsArr(),
				'thumb' => $mang->thumb_path,
				'views' => $mang->views,
				'created_at' => $mang->created_at->diffForHumans()
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
		$result = ['message' => 'failed save manga', 'success' => false];
		try {
			if ($data['id'] == '') {
				$manga = new Manga;
			} else {
				$manga = Manga::findOrFail($data['id']);
			}
			if (is_numeric($data['category'])) {
				try {
					$category = Category::findOrFail($data['category']);
				} catch (ModelNotFoundException $e) {
					$result['message'] = "Category is Not Number";
					$result['success'] = false;
					return $result;
				}
			} else {
				$category = new Category;
				$category->category = $data['category'];
				$category->save();
			}

			$manga->id_uploader = Sentinel::getUser()->id;
			$manga->title = $data['title'];
			$manga->description = $data['description'];
			$manga->thumb_path = $data['thumb'];
			
			$category->manga()->save($manga);

			$manga->setTags($data['tags']);

			$result['message'] = 'Success save';
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
			Manga::destroy($data['id']);
			$result['message'] = 'Success Delete data';
			$result['success'] = true;
		} catch (ModelNotFoundException $e) {
			$result['message'] = $e->getMessage();
			$result['success'] = false;
		}
		return $result;
	}

	public static function detailData($data) {
		$result = ['message' => 'Failed get detail', 'success' => false];
		if (! array_key_exists('id', $data)) return $result;

		try {
			$manga = Manga::findOrFail($data['id']);

			$data['title'] = $manga->title;
			$data['description'] = $manga->description;
			$data['category'] = $manga->category->category;
			$data['thumb'] = $manga->thumb_path;
			$data['views'] = $manga->views;
			$data['rating'] = ['rating' => 1.5, 'votes' => 1, 'enable' => false];
			$data['created_at'] = $manga->created_at->diffForHumans();
			$data['uploader'] = $manga->uploader->fullname();

			$result['data']['data'] = $data;
			$result['message'] = 'Success get data';
			$result['success'] = true;
		} catch (ModelNotFoundException $e) {
			$result['message'] = $e->getMessage();
			$result['success'] = false;
		}
		return $result;
	}
	
}