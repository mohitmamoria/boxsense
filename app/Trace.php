<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Node;

class Trace extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'traces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['hub_id', 'node_id', 'value', 'created_at_node'];

    public function node()
    {
        return $this->belongsTo(Node::class);
    }
}
