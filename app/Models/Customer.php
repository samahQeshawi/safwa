<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Carbon\Carbon;

class Customer extends Model
{

    use SpatialTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /*     protected $keyType = 'string';
    public $incrementing = false; */


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'user_type',
        'password',
        'user_id',
        'profile_image',
        'address',
        'zipcode',
        'gender',
        'dob',
        'location',
        'lat',
        'lng',
        'nationality_id',
        'country_id',
        'city_id',
        'national_id',
        'license_no',
        'national_file',
        'license_file',
        'is_active'
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
     * Get the booking record associated with the customer.
     */
    public function booking()
    {
        return $this->hasOne('App\Models\Booking');
    }
    /**
     * Get the user for this model.
     *
     * @return App\Models\User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
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
     * Get the Nationality for this model.
     *
     * @return App\Models\Country
     */
    public function nationality()
    {
        return $this->belongsTo('App\Models\Country', 'nationality_id');
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
        return $value ? 'Active' : 'Inactive';
    }
}
