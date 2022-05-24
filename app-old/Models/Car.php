<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Car extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cars';

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
        'service_id',
        'is_busy',
        'is_active',
        'rent_hourly',
        'rent_daily',
        'rent_weekly',
        'rent_monthly',
        'rent_yearly',
        'branch_id',
        'user_id',
        'car_name',
        'category_id',
        'car_type_id',
        'car_make_id',
        'fuel_type_id',
        'model_year',
        'seats',
        'transmission',
        'color',
        'engine',
        'engine_no',
        'short_description',
        'description',
        'registration_no',
        'insurance_expiry_date',
        'registration_file',
        'insurance_file',
        // 'location', Point
        'cancellation_before',
        /*'star',
                  'meta_keyword',
                  'meta_description',*/
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
     * Get the car photo for this model.
     *
     * @return App\Models\CarPhoto
     */
    public function carPhotos()
    {
        return $this->hasMany('App\Models\CarPhoto');
    }

    /**
     * Get the car type for this model.
     *
     * @return App\Models\Cartype
     */
    public function carType()
    {
        return $this->belongsTo('App\Models\CarType', 'car_type_id');
    }

    /**
     * Get the car make for this model.
     *
     * @return App\Models\Carmake
     */
    public function carMake()
    {
        return $this->belongsTo('App\Models\CarMake', 'car_make_id');
    }

    /**
     * Get the location for this model.
     *
     * @return App\Models\Branch
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Branch', 'branch_id');
    }

    public function scopeOrderByNearestBranch(Builder $query, $point)
    {
        //Order the branches by nearest one first
        //This scope is calling another score in SpatialTrait to sort it iin spatial distance
        $branches = Branch::select('id')->OrderByDistanceSphere('location', $point)->pluck('id')->toArray();
        $query->orderByRaw('FIELD(branch_id,'.implode(',',$branches).')');
    }

    /**
     * Get the car fuel for this model.
     *
     * @return App\Models\FuelType
     */
    public function carFuel()
    {
        return $this->belongsTo('App\Models\FuelType', 'fuel_type_id');
    }

    /**
     * Get the category for this model.
     *
     * @return App\Models\Category
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    /**
     * Get the service for this model.
     *
     * @return App\Models\Service
     */
    public function service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }

    /**
     * Get the service for this model.
     *
     * @return App\Models\Service
     */
    public function driver()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
     /**
     * Get the service for this model.
     *
     * @return App\Models\Service
     */
    public function categoryConfiguration()
    {
        return $this->belongsTo('App\Models\categoryConfiguration', 'category_id','category_id');
    }

    /**
     * Scope a query to only include active cars.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', '1');
    }


    /**
     * Scope a query to only include active cars.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBusy($query)
    {
        return $query->where('is_busy', '1');
    }

}
