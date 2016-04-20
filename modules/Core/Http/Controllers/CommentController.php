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
		$resdata = [];$coldata = [];$comments = [];
		$result = ['message' => 'Failed get comment', 'success' => false];

		if (array_key_exists('id_manga', $data)) {
			try {
				$manga = Manga::findOrFail($data['id_manga']);
				$comments = $manga->comments->sortBy('created_at');
			} catch (ModelNotFoundException $e) {
				$result['message'] = $e->getMessage();
				$result['success'] = false;
			}
		} elseif (array_key_exists('id_page', $data)) {
			try {
				$page = MangaPage::findOrFail($data['id_page']);
				$comments = $page->comments->sortBy('created_at');
			} catch (ModelNotFoundException $e) {
				$result['message'] = $e->getMessage();
				$result['success'] = false;
			}
		} else {
			return $result;
		}

		foreach ($comments as $comment) {
			$coldata[] = [
				'author' => $comment->user->fullname(),
				'comment' => $comment->comment,
				'created_at' => $comment->created_at->diffForHumans(),
				'image' => ''];
		} 

		$resdata['data'] = $coldata;
		$result['data'] = $resdata;
		$result['message'] = 'Success get comment';
		$result['success'] = true;
		return $result;
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