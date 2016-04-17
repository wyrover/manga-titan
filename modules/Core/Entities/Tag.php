<?php namespace Modules\Core\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

	public $timestamps = false;
    protected $fillable = [
    	'name',
        'slug',
        'count',
        'namespace',
    ];
    protected $table = 'tags';

    public function delete()
    {
        if ($this->exists) {
            $this->tagged()->delete();
        }

        return parent::delete();
    }

    public function tagged()
    {
        return $this->hasMany(__NAMESPACE__.'\Tagged', 'tag_id');
    }

    public function scopeSlug(Builder $query, $slug)
    {
        return $query->whereSlug($slug);
    }

    public function scopeName(Builder $query, $name)
    {
        return $query->whereName($name);
    }

    public function taggable()
    {
        return $this->morphTo();
    }
}