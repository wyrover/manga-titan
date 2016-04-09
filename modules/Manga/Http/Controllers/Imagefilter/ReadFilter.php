<?php

namespace Modules\Manga\Http\Controllers\Imagefilter;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ReadFilter implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->resize(800, null, function ($constraint) {
			$constraint->aspectRatio();
		})->encode('jpg', 70);
    }
}