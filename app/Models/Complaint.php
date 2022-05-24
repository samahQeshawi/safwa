<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Complaint extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'complaints';

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
                  'complaint_no',
				  'service_id',
                  'car_rental_id',
                  'trip_id',
                  'from_user_type',
                  'against_user_type',
                  'from_user_id',
                  'against_user_id',
                  'subject',
                  'complaint',
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
     * Get the form user type.
     *
     * @return App\Models\UserType
     */
    public function againstUserType()
    {
        return $this->belongsTo('App\Models\UserType','against_user_type');
    }

    /**
     * Get the form user type.
     *
     * @return App\Models\UserType
     */
    public function fromUserType()
    {
        return $this->belongsTo('App\Models\UserType','from_user_type');
    }

    /**
     * Get the service.
     *
     * @return App\Models\Service
     */
    public function service()
    {
        return $this->belongsTo('App\Models\Service','service_id');
    }

    /**
     * Get the from user.
     *
     * @return App\Models\User
     */
    public function from_user()
    {
        return $this->belongsTo('App\Models\User','from_user_id');
    }

    /**
     * Get the against user.
     *
     * @return App\Models\User
     */
    public function against_user()
    {
        return $this->belongsTo('App\Models\User','against_user_id');
    }

    /**
     * Get the car retnal for this model.
     *
     * @return App\Models\CarRental
     */
    public function car_rental()
    {
        return $this->belongsTo('App\Models\CarRental','car_rental_id');
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
