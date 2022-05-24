<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Carbon\Carbon;

class FavoritePlace extends Model
{
    use SpatialTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favorite_places';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'user_id',
                  'location',
                  'title',
                  'address',
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
    /**
     * @property \Grimzy\LaravelMysqlSpatial\Types\Point   $location
     */
    protected $spatialFields = [
        'location'
    ];

    /**
     * Get the users for this country.
     */

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

/**
     * Get created_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('MMMM Do YYYY, h:mm:ss a');

    }

    /**
     * Get updated_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('MMMM Do YYYY, h:mm:ss a');

    }

}
