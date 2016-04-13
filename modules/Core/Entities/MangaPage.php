<?php
namespace Modules\Core\Entities;
   
use Illuminate\Database\Eloquent\Model;

class MangaPage extends Model {

    protected $fillable = [];
    protected $table = 'manga_page';

    public function manga(){
    	return $this->belongsTo(__NAMESPACE__ . '\Manga', 'id_manga');
    }
}