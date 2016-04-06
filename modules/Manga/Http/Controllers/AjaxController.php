<?php namespace Modules\Manga\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class AjaxController extends Controller {
	
	public function processor()
	{
		$result = [];
		return response()->json($result);
	}
	
}