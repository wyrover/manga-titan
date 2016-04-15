<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Pingpong\Modules\Routing\Controller;
use Modules\Core\Http\Controllers\Iface\AjaxResponse;
use Modules\Core\Entities\Manga;
use Modules\Core\Entities\MangaPage;

class PageController extends Controller implements AjaxResponse {
	
	public static function getData($data) {
		$result = ['message' => 'Failed get page', 'success' => false];
		$resdata = [];$coldata = [];
		$page_num = (array_key_exists('page_num', $data) && intval($data['page_num']) > 0)?intval($data['page_num']):1;
		if (! array_key_exists('id_manga', $data)) return $result;

		try {
			$manga = Manga::findOrFail($data['id_manga']);
			$pages = $manga->mangapages->sortBy('page_num');
			$max_page = ceil($pages->count() / 50);
			$pages = $pages->forPage($page_num, 50);

			foreach ($pages as $page) {
				$coldata[] = [
					'id' => $page->id,
					'title'	=> 'Page ' . $page->page_num,
					'image' => $page->img_path
				];
			}

			$resdata = [
				'data' => $coldata,
				'max_page' => $max_page,
				'page_num' => $page_num
			];
			$result['data'] = $resdata;
			$result['message'] = 'Success get data';
			$result['success'] = true;
		} catch (ModelNotFoundException $e) {
			$result['message'] = $e->getMessage();
			$result['success'] = false;
		}
		return $result;
	}

	public static function saveData($data) {
		$result = ['message' => 'Failed save image', 'success' => false];
		if (! array_key_exists('id_manga', $data) || ! array_key_exists('image', $data)) return $result;

		try {
			$manga = Manga::findOrFail($data['id_manga']);
			$pages = $manga->mangapages->sortBy('page_num');
			$nextcounter = $pages->count() + 1;
			foreach ($data['image'] as $img) {
				$page = new MangaPage;
				$page->page_num = $nextcounter;
				$page->img_path = $img;
				$manga->mangapages()->save($page);
				$nextcounter++;
			}
			$result['message'] = 'Success Save Page';
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
			MangaPage::destroy($data['id']);
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
	
}