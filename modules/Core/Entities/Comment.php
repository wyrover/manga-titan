<?php
namespace Modules\Core\Entities;
   
use Baum\Node;
use Illuminate\Database\Eloquent\Model;

class Comment extends Node {

    protected $table = 'comment';

	protected $parentColumn = 'id_parent';

	protected $leftColumn = 'lidx';

	protected $rightColumn = 'ridx';

	protected $depthColumn = 'depth';

	protected $guarded = ['id', 'id_parent', 'lidx', 'ridx', 'depth'];
}