<?php namespace Modules\Manga\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use File;
use Response;

class ImageController extends Controller {

	public function upload(Request $r)
	{
		if ($r->hasFile('image')) {
			$image = $r->file('image');
			if (is_array($image)) {
				$filename = [];
				foreach ($image as $img) {
					$originalfname = $img->getClientOriginalName();
					$newfilename = sprintf('%s-%s', time(), $originalfname);
					$filename[$originalfname] = $newfilename;

					$img->move(storage_path('image'), $newfilename);
				}
				ksort($filename);
				$filename = array_values($filename);
			} else {
				$filename = sprintf('%s-%s', time(), $image->getClientOriginalName());

				$image->move(storage_path('image'), $filename);
			}
			return response()->json(['data' => ['filename' => $filename], 'success' => true]);
		}
		return response()->json(['success' => false]);
	}
	
	public function image($imgId)
	{
		return $this->getImage('image', $imgId);
	}

	public function thumb($imgId)
	{
		return $this->getImage('image', $imgId, 'medium');
	}

	public function getImage($path_storage, $filename, $imgsize = false)
	{
		$filePath = storage_path($path_storage) . '/' . $filename;
		if ( ! File::exists($filePath) )
			return Response::make("File does not exist." . $filename, 404);

		if ($imgsize !== false) {
			$image = null;
		}
		$fileContents = File::get($filePath);
		$mime = exif_imagetype($filePath);

		switch ($mime) {
			case IMAGETYPE_JPEG:
				$contentType = 'image/jpeg';break;
			case IMAGETYPE_GIF;
				$contentType = 'image/gif';break;
			case IMAGETYPE_PNG;
				$contentType = 'image/png';break;
			default:
				$contentType = false;break;
		}

		$header = [
			'Content-Type' => $contentType,
			'Last-Modified' => date('r', time()),
			'Expires' => date('r', time() + 3600)
		];
		return Response::make($fileContents, 200, $header);
	}
	
}