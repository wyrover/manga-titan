<?php

namespace Modules\Core\Http\Controllers\Iface;

interface AjaxResponse {
	public static function getData($data);
	public static function saveData($data);
	public static function deleteData($data);
	public static function detailData($data);
}