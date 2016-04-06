<?php namespace Modules\Manga\Entities;
   
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

    public function getTagsArr(){
    	$ret = [];
    	$tags = $this->tags;
    	foreach ($tags as $tag) {
    		$ret[] = $tag->name;
    	}
    	return $ret;
    }

}