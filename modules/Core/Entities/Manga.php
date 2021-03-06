<?php
namespace Modules\Core\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Manga extends Model implements TaggableInterface{

	use TaggableTrait;

    protected $fillable = [];
    protected $table = 'manga';

    public function category() {
    	return $this->belongsTo(__NAMESPACE__ . '\Category', 'id_category');
    }

    public function mangapages() {
        return $this->hasMany(__NAMESPACE__. '\MangaPage', 'id_manga');
    }

    public function uploader() {
        return $this->belongsTo(__NAMESPACE__.'\Users', 'id_uploader');
    }

    public function getTagsArr(){
    	$ret = [];
    	$tags = $this->tags;
    	foreach ($tags as $tag) {
    		$ret[] = $tag->name;
    	}
    	return $ret;
    }

    public function comments(){
        return $this->morphToMany(__NAMESPACE__.'\Comment', 'commentable', 'commentable');
    }

}