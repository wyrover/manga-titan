<?php namespace Modules\Core\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Users\EloquentUser;

class Users extends EloquentUser {

    protected $fillable = [];
    protected $table = 'users';

    public function manga() {
    	return $this->hasMany(__NAMESPACE__.'\Manga', 'id_uploader');
    }

    public function fullname() {
    	return $this->first_name . ' ' . $this->last_name;
    }
}