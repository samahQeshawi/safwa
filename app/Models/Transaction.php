<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
// use Hyn\Tenancy\Traits\UsesTenantConnection;
// use Devinweb\LaravelHyperpay\Models\Transaction as ModelsTransaction;

class Transaction extends Model
{
    // use UsesTenantConnection;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';

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
        'amount',
        'currency',
        'done_by',
        'sender_id',
        'receiver_id',
        'booking_id',
        'trip_id',
        'checkout_id',
        'status',
        'data',
        'trackable_data',
        'brand',
        'note'
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
    protected $casts = [
        'data'=> 'json',
        'trackable_data'=> 'json'
    ];
    /**
     * Get the user for this model.
     *
     * @return App\Models\User
     */
    public function doneBy()
    {
        return $this->belongsTo('App\Models\User','done_by');
    }
    /**
     * Get the driver for this model.
     *
     * @return App\Models\Driver
     */
    public function receiver()
    {
        return $this->belongsTo('App\Models\User','receiver_id');
    }

    /**
     * Get the customer for this model.
     *
     * @return App\Models\Customer
     */
    public function sender()
    {
        return $this->belongsTo('App\Models\User','sender_id');
    }
    /**
     * Get the booking for this model.
     *
     * @return App\Models\Booking
     */
    public function booking()
    {
        return $this->belongsTo('App\Models\CarRental','booking_id');
    }
    /**
     * Get the trip for this model.
     *
     * @return App\Models\Trip
     */
    public function trip()
    {
        return $this->belongsTo('App\Models\Trip','trip_id');
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
