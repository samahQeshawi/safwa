<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Carbon\Carbon;

class Driver extends Model
{
    use SpatialTrait;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'drivers';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;


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
        'country_code',
        'nationality_id',
        'dob',
        'location',
        'lat',
        'lng',
        'is_available',
        'birth_certificate_file',
        'passport_file',
        'is_safwa_driver',
        'is_active',
        'national_id',
        'national_file',
        'license_file',
        'insurance_file',
        'profile_image',
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
     * Get the Matoionality for this model.
     *
     * @return App\Models\User
     */
    public function nationality()
    {
        return $this->belongsTo('App\Models\Country', 'nationality_id');
    }

    /**
     * Get the user for this model.
     *
     * @return App\Models\User
     */
    public function car()
    {
        return $this->hasOne('App\Models\Car', 'user_id');
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
     * Get the car type for this model.
     *
     * @return App\Models\CarType
     */
    public function cartype()
    {
        return $this->belongsTo('App\Models\CarType', 'car_type_id');
    }
    /**
     * Set the dob.
     *
     * @param  string  $value
     * @return void
     */
    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = !empty($value) ? Carbon::parse($value)->isoFormat('Y-MM-DD') : null;
    }


    /**
     * Get dob in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getDobAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('Y-MM-DD');
    }


    /**
     * Get id_expiry_date in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getIdExpiryDateAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('Y-MM-DD');
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
     * Get the User Status.
     *
     * @param  string  $value
     * @return string
     */
    public function getIsActiveAttribute($value)
    {
        return $value ? 'Active' : 'Inactive';
    }


    /**
     * Scope a query to only include active coupons.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', 1);
    }

    /**
     * Scope a query to only include active coupons.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMyAvailability($query)
    {
        return $query->where('user_id', auth()->user()->id)->where('is_available', 1);
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
