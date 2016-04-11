<?php namespace Modules\Core\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class CoreController extends Controller {

	protected $actions;

	public function __construct() {
		$this->registerAction();
	}
	
	public function ajaxProcessor() {
		return response()->json(['success' => false]);
	}

	public function registerAction() {
		$this->actions = [];
	}
	
}