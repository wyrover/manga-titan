<?php namespace Modules\Manga\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $fillable = ['category', 'description'];
    protected $table = 'category';
}