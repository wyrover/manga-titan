<?php

namespace Modules\Manga\Http\Controllers\Traitajax;

use Modules\Manga\Entities\Manga;
use Modules\Manga\Entities\MangaPage;
use Modules\Manga\Entities\Category;
use File;

trait TraitManga {
	public function filterManga($data) {
		$result = ['message' => '', 'success' => false];
		$manga_arr = [];
		$page_num = (isset($data['page_num']) && $data['page_num'] != 0)?$data['page_num']:1;
		$manga_list = Manga::orderBy('created_at','desc')->get();

		$max_page = ceil($manga_list->count() / 20);
		$manga_list = $manga_list->forPage($page_num, 20);
		foreach ($manga_list as $manga) {
			$manga_arr[] = [
				'manga_id' => $manga->id,
				'manga_title' => $manga->title,
				'manga_desc' => $manga->description,
				'manga_pages' => $manga->mangapages->count(),
				'manga_cover' => $manga->thumb_path,
				'manga_category' => $manga->category,
				'manga_views' => $manga->views,
				'manga_tags' => $manga->getTagsArr(),
				'manga_upload' => $manga->created_at->diffForHumans()
			];
		}

		$result['data'] = ['manga_list' => $manga_arr, 'max_page' => $max_page, 'page_num' => $page_num];
		$result['success'] = true;
		return $result;
	}
	public function getMangaDesc($id_manga) {
		return Manga::find($id_manga);
	}
	public function getPages($data) {
		$result = ['message' => '', 'success' => false];
		try {
			$manga = Manga::findOrFail($data['manga_id']);
			if ($manga->mangapages->count() > 0) {
				$pages = $manga->mangapages->sortBy('page_num');
				$dataret = [];
				foreach ($pages as $page) {
					$dataret[] = $page->img_path;
				}
				$result['data'] = $dataret;
				$result['message'] = 'Success get page';
				$result['success'] = true;
			} else {
				$result['data'] = [];
				$result['message'] = 'There is no page here';
				$result['success'] = false;
			}
		} catch (ModelNotFoundException $e) {
			$result['message'] = $e->getMessage();
			$result['success'] = false;
		}
		return $result;
	}
}