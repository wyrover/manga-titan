<?php
namespace Modules\Manga\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Manga\Http\Controllers\Traitajax\TraitManga;

class AjaxController extends Controller {

	use TraitManga;
	
	public function processor(Request $request)
	{
		$result = [];
		switch ($request->client_action) {
			case 'get-manga':
				$result = $this->getManga($request->data);
				break;
			case 'get-category':
				$result = $this->getCategory();
				break;
			case 'get-tags':
				$result = $this->getTags();
				break;
			case 'save-manga': 
				$result = $this->saveManga($request->data);
				break;
			case 'delete-manga':
				$result = $this->deleteManga($request->data);
				break;
			default:
				$result['message'] = 'undefined client action';
				$result['success'] = false;
		}
		return response()->json($result);
	}
	
}