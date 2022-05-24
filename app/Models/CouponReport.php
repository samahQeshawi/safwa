<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CouponReport extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'coupon_reports';

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
                    'coupon_code',
                    'user_id',
                    'service_id',
                    'applied_for_id',
                    'applied_on',
                    'total_amount',
                    'coupon_discount_amount',
              ];
    /** 
     * disable timestamp
     *
     */       
    public $timestamps = false;
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
     * Get the Service for this model.
     *
     * @return App\Models\City
     */
    public function service()
    {
        return $this->belongsTo('App\Models\Service','service_id');
    }
    /**
     * Get the country for this model.
     *
     * @return App\Models\Country
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    /**
     * Get the city for this model.
     *
     * @return App\Models\City
     */
    public function carRental()
    {
        return $this->belongsTo('App\Models\CarRental','applied_for_id');
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
