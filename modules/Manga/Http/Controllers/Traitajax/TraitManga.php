<?php

namespace Modules\Manga\Http\Controllers\Traitajax;

use Modules\Manga\Entities\Manga;
use Modules\Manga\Entities\Category;

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
}