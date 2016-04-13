<?php
namespace Modules\Core\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $fillable = [];
    protected $table = 'category';
    public function manga(){
    	return $this->hasMany(__NAMESPACE__.'\Manga', 'id_category');
    }
}