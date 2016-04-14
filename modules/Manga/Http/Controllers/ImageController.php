<?php namespace Modules\Manga\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use File;
use Response;
use Uuid;

class ImageController extends Controller {

	public function upload(Request $r)
	{
		if ($r->hasFile('image')) {
			$image = $r->file('image');
			if (is_array($image)) {
				$filename = [];
				foreach ($image as $img) {
					$newfilename = sprintf('%s.%s', Uuid::generate(4), $img->getClientOriginalExtension());
					$filename[$originalfname] = $newfilename;

					$img->move(storage_path('image'), $newfilename);
				}
				ksort($filename);
				$filename = array_values($filename);
			} else {
				$filename = sprintf('%s.%s', Uuid::generate(4), $image->getClientOriginalExtension());

				$image->move(storage_path('image'), $filename);
			}
			return response()->json(['data' => ['filename' => $filename], 'success' => true]);
		}
		return response()->json(['success' => false]);
	}
}