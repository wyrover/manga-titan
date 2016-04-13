<?php
namespace Modules\Core\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $fillable = [];
    protected $table = 'comments';
}