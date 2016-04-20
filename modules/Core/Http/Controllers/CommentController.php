<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Pingpong\Modules\Routing\Controller;
use Modules\Core\Http\Controllers\Iface\AjaxResponse;
use Modules\Core\Entities\Manga;
use Modules\Core\Entities\MangaPage;
use Modules\Core\Entities\Comment;
use Sentinel;

class CommentController extends Controller implements AjaxResponse {
	
	public static function getData($data) {
		//
	}

	public static function saveData($data) {
		$result = ['message' => 'Failed save comment', 'success' => false];
		if (! array_key_exists('comment', $data)) return $result;

		$comment = new Comment;
		$comment->id_users = Sentinel::getUser()->id;
		$comment->comment = $data['comment'];

		if (array_key_exists('id_manga', $data)) {
			try {
				$manga = Manga::findOrFail($data['id_manga']);
				$manga->comments()->save($comment);
				$result['message'] = "Comment saved";
				$result['success'] = true;
			} catch (ModelNotFoundException $e) {
				$result['message'] = $e->getMessage();
				$result['success'] = false;
			}
		} elseif (array_key_exists('id_page', $data)) {
			try {
				$page = MangaPage::findOrFail($data['id_page']);
				$page->comments()->save($comment);
				$result['message'] = "Comment saved";
				$result['success'] = true;
			} catch (ModelNotFoundException $e) {
				$result['message'] = $e->getMessage();
				$result['success'] = false;
			}
		}
		
		return $result;
	}
	
	public static function deleteData($data) {
		//
	}

	public static function detailData($data) {
		//
	}
	
}