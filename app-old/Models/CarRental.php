<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CarRental extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'car_rentals';

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
                  'booking_no',
                  'user_id',
                  'car_id',
                  'branch_id',
				  'pickup_on',
				  'pickup_lat',
				  'pickup_lng',
				  'duration_in_days',
				  'dropoff_on',
				  'dropoff_lat',
				  'dropoff_lng',
                  'amount',
                  'discount',
                  'final_amount',
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
     * Get the driver for this model.
     *
     * @return App\Models\Driver
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    /**
     * Get the Car for this model.
     *
     * @return App\Models\Driver
     */
    public function car()
    {
        return $this->belongsTo('App\Models\Car','car_id');
    }
        /**
     * Get the branch for this model.
     *
     * @return App\Models\Driver
     */
    public function branch()
    {
        return $this->belongsTo('App\Models\Branch','branch_id');
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
