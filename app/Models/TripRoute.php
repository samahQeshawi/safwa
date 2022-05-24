<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripRoute extends Model
{
    use HasFactory;

    protected $table = 'trip_routes';
    public $timestamps = false;

    protected $fillable = [
        'trip_id',
        'lat',
        'lng'
    ];

    public function trip()
    {
        return $this->hasOne('\App\Models\Trip');
    }


}
