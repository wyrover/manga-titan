<?php
namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Entities\Manga;
use Modules\Core\Entities\MangaPage;
use Modules\Core\Entities\Category;
use File;

class ModelEventProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function boot() {
		Manga::deleting(function ($manga) {
			$pages = $manga->mangapages;
			if ($pages->count() > 0) {
				foreach ($pages as $page) {
					$page->delete();
				}
			}
			if ($manga->thumb_path != '') {
				if (File::exists(storage_path('image/'.$manga->thumb_path)))
					File::delete(storage_path('image/'.$manga->thumb_path));
			}
		});
		MangaPage::deleting(function ($page) {
			if ($page->img_path != '') {
				if (File::exists(storage_path('image/'. $page->img_path)))
					File::delete(storage_path('image/' . $page->img_path));
			}
		});
		MangaPage::deleted(function ($page) {
			$pages = MangaPage::where('id_manga', $page->id_manga)->orderBy('page_num')->get();
			if ($pages->count() > 0) {
				foreach ($pages as $index => $page) {
					$page->page_num = $index + 1;
					$page->save();
				}
			}
		});
		Manga::updating(function ($manga) {
			$oldmanga = $manga->getOriginal();
			if ($oldmanga['thumb_path'] != $manga->thumb_path && $oldmanga['thumb_path'] != '') {
				if (File::exists(storage_path('image/'. $oldmanga['thumb_path'])))
					File::delete(storage_path('image/'. $oldmanga['thumb_path']));
			}
		});
		Manga::saving(function ($manga) {
			$filename = preg_replace("/[^a-zA-Z0-9.\-]/", "-", $manga->thumb_path);
			if ($filename != $manga->thumb_path) {
				File::move(storage_path('image/'.$manga->thumb_path), storage_path('image/'.$filename));
				$manga->thumb_path = $filename;
			}
		});
		Category::deleting(function ($category) {
			if ($category->thumb_path != '') {
				if (File::exists(storage_path('image/'.$category->thumb_path)))
					File::delete(storage_path('image/'.$category->thumb_path));
			} 
		});
		Category::updating(function ($category) {
			$old = $category->getOriginal();
			if ($old['thumb_path'] != $category->thumb_path && $old['thumb_path']!='') {
				if (File::exists(storage_path('image/'.$old['thumb_path'])))
					File::delete(storage_path('image/'.$old['thumb_path']));
			}
		});
	}

	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
