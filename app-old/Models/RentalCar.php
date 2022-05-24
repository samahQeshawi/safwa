<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RentalCar extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rental_cars';

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
				  'user_id',
				  'car_id',
				  'pickup_on',
                  'duration_in_days',
				  'return_on',
				  'dropoff_on',
                  'amount'
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
    public function car()
    {
        return $this->belongsTo('App\Models\Car','car_id');
    }

    /**
     * Get the Customer for this model.
     *
     * @return App\Models\Customer
     */
    public function customer()
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
