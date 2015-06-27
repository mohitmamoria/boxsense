<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hub, App\Trace;

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
    protected $fillable = ['uuid', 'generation', 'type', 'capacity'];

    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }

    public function traces()
    {
        return $this->hasMany(Trace::class);
    }

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
            ->whereNull('connected_at')
            ->firstOrFail();
    }

    public static function connected()
    {
        return static::whereNotNull('connected_at')
            ->whereNotNull('hub_id')
            ->get();
    }

    public function latestTrace()
    {
        return $this->traces()->latest('created_at_node')->first();
    }
}
