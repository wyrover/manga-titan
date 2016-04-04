<?php namespace Modules\Manga\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use File;
use Response;

class ImageController extends Controller {
	
	public function image($imgId)
	{
		return $this->generateImage('image', $imgId);
	}

	public function thumb($imgId)
	{
		return ;
	}

	public function generateImage($path_storage, $filename, $imgsize = false)
	{
		$filePath = storage_path($path_storage) . '/' . $filename;
		if ( ! File::exists($filePath) )
			return Response::make("File does not exist." . $filePath, 404);

		$fileContents = File::get($filePath);
		$mime = exif_imagetype($filePath);

		switch ($mime) {
			case IMAGETYPE_JPEG:
				$contentType = 'image/jpeg';break;
			case IMAGETYPE_GIF;
				$contentType = 'image/gif';
			case IMAGETYPE_PNG;
				$contentType = 'image/png';
			default:
				$contentType = false;break;
		}

		return Response::make($fileContents, 200, array('Content-Type' => $contentType));
	}
	
}