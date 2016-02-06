<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Node;

class Hub extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hubs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid', 'salt'];

    public function nodes()
    {
        return $this->hasMany(Node::class);
    }

    public static function findByUuid($uuid)
    {
        return static::where('uuid', $uuid)->first();
    }
}
