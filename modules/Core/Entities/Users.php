<?php namespace Modules\Core\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Users\EloquentUser;

class Users extends EloquentUser {

    protected $fillable = [];
    protected $table = 'users';

}