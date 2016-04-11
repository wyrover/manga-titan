<?php
namespace Modules\Manga\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Manga\Http\Controllers\Traitajax\TraitManga;
use Modules\Manga\Http\Controllers\Traitajax\TraitAdmin;
use Modules\Manga\Http\Controllers\Traitajax\TraitUsers;

class AjaxController extends Controller {

	use TraitAdmin;
	use TraitManga;
	use TraitUsers;
	
	public function processor(Request $request)
	{
		$result = [];
		switch ($request->client_action) {
			case 'get-user':
				$result = $this->getUsers($request->data['page_num']);
				break;
			case 'get-manga':
				$result = $this->getManga($request->data);
				break;
			case 'get-category':
				$result = $this->getCategory();
				break;
			case 'get-tags':
				$result = $this->getTags();
				break;
			case 'get-page':
				$result = $this->getPage($request->data);
				break;
			case 'get-pages-for-view':
				$result = $this->getPages($request->data);
				break;
			case 'add-page':
				$result = $this->addPage($request->data);
				break;
			case 'save-manga': 
				$result = $this->saveManga($request->data);
				break;
			case 'user-save':
				$result = $this->saveUser($request->data);
				break;
			case 'user-delete':
				$result = $this->deleteUser($request->data);
				break;
			case 'delete-manga':
				$result = $this->deleteManga($request->data);
				break;
			case 'delete-page':
				$result = $this->deletePage($request->data);
				break;
			case 'delete-all-pages':
				$result = $this->deleteAllPages($request->data);
				break;
			case 'change-order':
				$result = $this->changeOrder($request->data);
				break;
			case 'filter-manga':
				$result = $this->filterManga($request->data);
				break;
			default:
				$result['message'] = 'undefined client action';
				$result['success'] = false;
		}
		$result['new_csrf'] = csrf_token();
		return response()->json($result);
	}
	
}