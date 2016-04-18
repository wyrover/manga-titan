<?php
namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model {

	protected $fillable = [];
	protected $table = 'rating';

	public function manga() {
		$this->belongsTo(__NAMESPACE__.'\Manga', 'id_manga');
	}

	public function users() {
		$this->belongsTo(__NAMESPACE__.'\Users', 'id_users');
	}
}