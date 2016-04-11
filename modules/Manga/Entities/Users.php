<?php namespace Modules\Manga\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Users extends Model {

    protected $fillable = [];
    protected $table = 'users';

    public function activation() {
    	return $this->hasOne(__NAMESPACE__.'\Activation', 'user_id');
    }
}