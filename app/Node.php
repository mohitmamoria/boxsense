<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid', 'generation', 'type'];

    public static function findByUuid($uuid)
    {
        return static::where('uuid', $uuid)->first();
    }

    public static function findForConnection($uuid, $generation, $type)
    {
        return static::where('uuid', $uuid)
            ->where('generation', $generation)
            ->where('type', $type)
            ->whereNull('hub_id')
            ->firstOrFail();
    }
}
