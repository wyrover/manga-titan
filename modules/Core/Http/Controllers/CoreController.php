<?php
namespace Modules\Core\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;

class CoreController extends Controller {

	protected $actions;

	public function __construct() {
		$this->registerAction();
	}
	
	public function ajaxProcessor(Request $request) {
		if (array_key_exists($request->client_action, $this->actions)) {
			$result = call_user_func($this->actions[$request->client_action], $request->data);
		} else {
			$result = ['message' => 'Undefined user action', 'success' => false];
		}
		return response()->json($result);
	}

	public function registerAction() {
		$this->actions = [
			'get-category'		=> __NAMESPACE__.'\CategoryController::getData',
			'save-category'		=> __NAMESPACE__.'\CategoryController::saveData',
			'delete-category'	=> __NAMESPACE__.'\CategoryController::deleteData',

			'get-tags'			=> __NAMESPACE__.'\TagsController::getData',
			'save-tags'			=> __NAMESPACE__.'\TagsController::saveData',
			'delete-tags'		=> __NAMESPACE__.'\TagsController::deleteData',

			'get-user'			=> __NAMESPACE__.'\UserController::getData',
			'save-user'			=> __NAMESPACE__.'\UserController::saveData',
			'delete-user'		=> __NAMESPACE__.'\UserController::deleteData',

			'get-comment'		=> __NAMESPACE__.'\CommentController::getData',
			'delete-comment'	=> __NAMESPACE__.'\CommentController::deleteData',

			'get-manga'			=> __NAMESPACE__.'\MangaController::getData',
			'save-manga'		=> __NAMESPACE__.'\MangaController::saveData',
			'delete-manga'		=> __NAMESPACE__.'\MangaController::deleteManga',
			
			'get-page'			=> __NAMESPACE__.'\PageController::getData',
			'save-page'			=> __NAMESPACE__.'\PageController::saveData',
			'delete-page'		=> __NAMESPACE__.'\PageController::deleteData',
		];
	}
	
}