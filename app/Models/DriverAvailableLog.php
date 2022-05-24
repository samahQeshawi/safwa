<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverAvailableLog extends Model
{
    use HasFactory;

    protected $table = 'driver_available_logs';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'is_available',
        'updated_on',
    ];

    public function driver()
    {
        return $this->hasOne('\App\Models\User');
    }


    /**
     * Scope a query to only include logged in user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMyLog($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    /**
     * Scope a query to only include online logs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnline($query)
    {
        return $query->where('is_available', 1);
    }

    /**
     * Scope a query to only include offline logs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOffline($query)
    {
        return $query->where('is_available', 0);
    }


}
