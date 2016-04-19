<?php
namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $table = 'comment';

    public function manga() {
        return $this->morphedByMany(__NAMESPACE__.'\Manga', 'commentable', 'commentable');
    }

    public function page() {
        return $this->morphedByMany(__NAMESPACE__.'\MangaPage', 'commentable', 'commentable');
    }

}