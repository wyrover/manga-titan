<?php

namespace Modules\Manga\Http\Controllers\Imagefilter;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ThumbFilter implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->resize(200, null, function ($constraint) {
			$constraint->aspectRatio();
		});;
    }
}