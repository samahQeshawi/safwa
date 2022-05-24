<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Category extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

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
                  'category',
                  'image_file',
                  'service_id',
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
     * Get the configuration for this model.
     *
     * @return App\Models\CategoryConfiguration
     */
    public function categoryConfiguration()
    {
        return $this->belongsTo('App\Models\CategoryConfiguration','id','category_id');
    }

    /**
     * Get the service for this model.
     *
     * @return App\Models\Driver
     */
    public function service()
    {
        return $this->belongsTo('App\Models\Service','service_id');
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
     * Get the Categories Status.
     *
     * @param  string  $value
     * @return string
     */
    public function getIsActiveAttribute($value)
    {
        return $value ? 'Yes': 'No';
    }

}
