<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Builder;

class Branch extends Model
{

    use SpatialTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'branches';

    /**
    * The database primary key value.
    *
    * @var string
    */



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                    'name',
                    'address',
                    'email',
                    'phone',
                    'branch_code',
                    'country_id',
                    'city_id',
                    'latitude',
                    'longitude',
                    'is_active'
              ];

    /**
     * @property \Grimzy\LaravelMysqlSpatial\Types\Point   $location
     */
    protected $spatialFields = [
        'location'
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
     * Get the country for this model.
     *
     * @return App\Models\Country
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country','country_id');
    }

    /**
     * Get the city for this model.
     *
     * @return App\Models\City
     */
    public function city()
    {
        return $this->belongsTo('App\Models\City','city_id');
    }

    /**
     * Get the city for this model.
     *
     * @return App\Models\City
     */
    public function service()
    {
        return $this->belongsTo('App\Models\Service','service_id');
    }

    public function scopeOrderByNearest(Builder $query, $point)
    {
        //Order the branches by nearest one first
        //This scope is calling another scope in SpatialTrait to sort it in spatial distance
        $branches = $this->select('id')->OrderByDistanceSphere('location', $point)->pluck('id')->toArray();
        $query->orderByRaw('FIELD(branch_id,'.implode(',',$branches).')');
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

    /**
     * Get the Stores Status.
     *
     * @param  string  $value
     * @return string
     */
    public function getIsActiveAttribute($value)
    {
        return $value ? 'Active': 'Inactive';
    }

    /**
     * Scope a query to only include active coupons.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
