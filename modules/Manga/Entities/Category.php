<?php namespace Modules\Manga\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $fillable = ['category', 'description'];
    protected $table = 'category';
    public function manga(){
    	return $this->hasMany(__NAMESPACE__.'\Manga', 'id_category');
    }
}