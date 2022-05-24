<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rating extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ratings';

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
        'trip_id',
        'user_type',
        'rated_by',
        'rated_for',
        'rating',
        'rating_comment',
        'done_by',
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
     * Get the rated by this model.
     *
     * @return App\Models\User
     */
    public function trip()
    {
        return $this->belongsTo('App\Models\Trip', 'trip_id');
    }

    /**
     * Get the rated by this model.
     *
     * @return App\Models\User
     */
    public function ratedBy()
    {
        return $this->belongsTo('App\Models\User', 'rated_by');
    }

    /**
     * Get the rated for this model.
     *
     * @return App\Models\User
     */
    public function ratedFor()
    {
        return $this->belongsTo('App\Models\User', 'rated_for');
    }

    /**
     * Get the rated by this model.
     *
     * @return App\Models\User
     */
    public function doneBy()
    {
        return $this->belongsTo('App\Models\User', 'done_by');
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
