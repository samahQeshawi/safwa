<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Carbon\Carbon;

class Trip extends Model
{
    use SpatialTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trips';

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
        'trip_no',
        'is_now_trip',
        'service_id',
        'status',
        'customer_id',
        'driver_id',
        'car_id',
        'from_address',
        'from_location',
        'from_location_lat',
        'from_location_lng',
        'to_address',
        'to_location',
        'to_location_lat',
        'to_location_lng',
        'pickup_on',
        'dropoff_on',
        'distance',
        'category_id',
        'minimum_charge',
        'km_charge',
        'cancellation_charge',
        'amount',
        'discount',
        'tax',
        'final_amount',
        'payment_method',
        'payment_method_id',
        'payment_status',
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
        'from_location', 'to_location'
    ];


    public function getPickupOnAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function getDropoffOnAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
    /**
     * Get created_at in array format
     *
     * @param  string  $value
     * @return array
     */
    /* public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('MMMM Do YYYY, h:mm:ss a');
    } */

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
     * Get the driver for this model.
     *
     * @return App\Models\Driver
     */
    public function driver()
    {
        return $this->belongsTo('App\Models\User', 'driver_id');
    }

    /**
     * Get the customer for this model.
     *
     * @return App\Models\Customer
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\User', 'customer_id');
    }
    /**
     * Get the Service for this model.
     *
     * @return App\Models\Customer
     */
    public function service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }
    /**
     * Get the Category for this model.
     *
     * @return App\Models\Customer
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
    /**
     * Get the Payment Method for this model.
     *
     * @return App\Models\Customer
     */
    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod', 'payment_method');
    }
    /**
     * Get the car rent for this model.
     *
     * @return App\Models\Car
     */
    public function car()
    {
        return $this->belongsTo('App\Models\Car', 'car_id');
    }
}
