<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripRequestLog extends Model
{
    use HasFactory;

    protected $table = 'trip_request_logs';

    protected $fillable = [
        'user_id',
        'trip_id',
        'status',
    ];

    public function trip()
    {
        return $this->hasOne('\App\Models\Trip');
    }

    public function driver()
    {
        return $this->hasOne('\App\Models\User');
    }


    /**
     * Scope a query to only include accepted trips.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 1);
    }


}
