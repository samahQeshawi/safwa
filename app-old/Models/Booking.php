<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bookings';

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
                  'customer_id',
                  'booking_no',
                  'booking_code',
				  'start_destination',
				  'start_latitude',
				  'start_longitude',
                  'end_destination',
				  'end_latitude',
				  'end_longitude',
                  'distance',
                  'start_date',
                  'start_time',
                  'amount',
                  'landmark',
                  'start_address',
                  'car_type_id',
                  'driver_id',
                  'status',
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
     * Get the driver for this model.
     *
     * @return App\Models\Driver
     */
    public function driver()
    {
        return $this->belongsTo('App\Models\User','driver_id');
    }

    /**
     * Get the Customer for this model.
     *
     * @return App\Models\Customer
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\User','customer_id');
    }

	/**
     * Get the car type for this model.
     *
     * @return App\Models\Cartype
     */
    public function cartype()
    {
        return $this->belongsTo('App\Models\Cartype','car_type_id');
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
