<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otps extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'otps';

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
                  'country_id',
                  'phone',
                  'otp',
                  'otp_expire_on',
                  'user_id',
                  'user_type_id',
                  'phone_code',
                  'password',
              ];
    /**
     * Get the users for this country.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');;
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
