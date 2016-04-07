<?php

namespace Modules\Manga\Http\Controllers\Traitajax;

use Modules\Manga\Entities\Manga;
use Modules\Manga\Entities\MangaPage;
use Modules\Manga\Entities\Category;
use File;

trait TraitManga {
	public function saveManga($data) {
		$result = ['message' => 'failed save manga', 'success' => false];
		
		try {
			$manga = ($data['manga_id']=='')?new Manga:Manga::findOrNew($data['manga_id']);

			if (is_numeric($data['manga_category'])) {
				try {
					$category = Category::findOrFail($data['manga_category']);
				} catch (ModelNotFoundException $e) {
					$result['message'] = "Don't input number in category";
					$result['success'] = false;
					return $result;
				}
			} elseif ($category = Category::where('category', $data['manga_category'])->get()) {
				if ($category->count() == 0) {
					$category = new Category;
					$category->category = $data['manga_category'];
					$category->save();
				} else {
					$category = $category->first();
				}
			}

			$manga->title = $data['manga_title'];
			$manga->description = $data['manga_desc'];
			$manga->thumb_path = $data['manga_cover'];
			
			$category->manga()->save($manga);

			$manga->setTags($data['manga_tags']);

			$result['data'] = [
				'manga_id' => $manga->id,
				'manga_title' => $manga->title,
				'manga_desc' => $manga->description,
				'manga_cover' => $manga->thumb_path,
				'manga_category' => $category->id,
				'manga_tags' => $manga->getTagsArr(),
				];
			$result['message'] = 'Success save';
			$result['success'] = true;
		} catch (ModelNotFoundException $e) {
			$result['message'] = $e->getMessage();
			$result['success'] = false;
		}
		
		return $result;
	}

	public function deleteManga($data) {
		$result = ['message' => '', 'success' => false];
		try {
			Manga::destroy($data['manga_id']);

			$result['message'] = 'Success delete manga';
			$result['success'] = true;
		} catch (ModelNotFoundException $e) {
			$result['message'] = $e->getMessage();
			$result['success'] = false;
		}
		return $result;
	}

	public function getManga($data) {
		$manga_list = Manga::all();
		$manga_arr = [];
		$max_page = ceil($manga_list->count() / 10);
		if (isset($data['page_num']))
			$manga_list = $manga_list->forPage($data['page_num'], 10);
		else
			$manga_list = $manga_list->forPage(1, 10);

		foreach ($manga_list as $manga) {
			$manga_arr[] = [
				'manga_id' => $manga->id,
				'manga_title' => $manga->title,
				'manga_desc' => $manga->description,
				'manga_cover' => $manga->thumb_path,
				'manga_category' => $manga->category->category,
				'manga_tags' => $manga->getTagsArr(),
				'manga_upload' => $manga->created_at->diffForHumans()
			];
		}
		$ret_data = ['max_page' => $max_page, 'manga' => $manga_arr];

		return ['data' => $ret_data, 'message' => 'Success get mangaes', 'success' => true];
	}

	public function getTags() {
		$tags = Manga::allTags()->get();
		$data = [];

		foreach ($tags as $tag) {
			$data[] = ['name' => $tag->name];
		}
		return ['data' => $data, 'message' => 'Success get tags', 'success' => true];
	}

	public function getCategory(){
		$categories = Category::all();
		$data = [];

		foreach ($categories as $category) {
			$data[] = ['id'=>$category->id, 'category'=>$category->category];
		}
		return ['data' => $data, 'message' => 'Success get category', 'success' => true];
	}

	public function addPage($data) {
		$result = ['message' => 'failed save page', 'success' => false];

		try {
			$manga = Manga::findOrFail($data['manga_id']);

			if ($manga->mangapages->count() > 0)
				$page_order = $manga->mangapages->count() + 1;
			else
				$page_order = 1;

			foreach ($data['pages'] as $page) {
				$manga_page = new MangaPage;
				$manga_page->page_num = $page_order;
				$manga_page->img_path = $page;

				$manga->mangapages()->save($manga_page);
				$page_order++;
			}

			$result = $this->getPage($data);
			$result['message'] = 'Success add pages';
		} catch (ModelNotFoundException $e) {
			$result['message'] = $e->getMessage();
			$result['success'] = false;
		}

		return $result;
	}

	public function getFormatedPages($manga_id, $page_num = 1) {
		$pages = Manga::find($manga_id);
		$tmppage = [];
		$max_page = 0;
		if ($pages->mangapages->count() > 0) {
			$max_page = ceil($pages->mangapages->count() / 50);
			$pages = $pages->mangapages->forPage($page_num, 50);
			foreach ($pages as $page) {
				$tmppage[] = ['page_id' => $page->id, 'page_order' => $page->page_num, 'img_path' => $page->img_path];
			}
		}
		return ['pages' => $tmppage, 'max_page' => $max_page];
	}

	public function getPage($data) {
		$result = ['message' => 'Failed get page', 'success' => false];

		try {
			$manga = Manga::findOrFail($data['manga_id']);

			$result['data'] = $this->getFormatedPages($data['manga_id'], isset($data['page_num'])?$data['page_num']:1);
			$result['message'] = 'Success get pages';
			$result['success'] = true;
		} catch (ModelNotFoundException $e) {
			$result['message'] = $e->getMessage();
			$result['success'] = false;
		}

		return $result;
	}

	public function deleteAllPages($data) {
		$result = ['message' => 'Failed delete page', 'success' => false];
		try {
			$manga = Manga::findOrFail($data['manga_id']);
			if ($manga->mangapages->count() > 0) {
				foreach ($manga->mangapages as $pages) {
					File::delete(storage_path('image/') . $pages->img_path);
				}
			}
			$manga->mangapages()->delete();

			$result['message'] = 'Success delete all pages';
			$result['success'] = true;
		} catch (ModelNotFoundException $e) {
			$result['message'] = $e->getMessage();
			$result['success'] = false;
		}
		return $result;
	}

	public function deletePage($data) {
		$result = ['message' => 'failed delete page', 'success' => false];
		try {
			$page = MangaPage::findOrFail($data['page_id']);
			File::delete(storage_path('image/') . $page->img_path);
			$page->delete();

			$result['message'] = 'Success delete all pages';
			$result['success'] = true;
		} catch (ModelNotFoundException $e) {
			$result['message'] = $e->getMessage();
			$result['success'] = false;
		}
		return $result;
	}
}