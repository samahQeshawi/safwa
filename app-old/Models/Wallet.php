<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Wallet extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wallets';

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
                  'user_id',
				  'amount',
                  'user_type',
                  'is_active',
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
     * Get the user for this model.
     *
     * @return App\Models\User
     */
    public function user()
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

    /**
     * Get the Wallet Status.
     *
     * @param  string  $value
     * @return string
     */
    public function getIsActiveAttribute($value)
    {
        return $value ? 'Yes': 'No';
    }
}
