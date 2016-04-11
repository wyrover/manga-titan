<?php namespace Modules\Manga\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Activation extends Model {

    protected $fillable = [];
    protected $table = 'activations';

    public function user() {
    	return $this->belongsTo(__NAMESPACE__.'\Users', 'user_id');
    }
}