<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPaymentOption extends Model
{
    use HasFactory;

    protected $table = 'user_payment_options';

    protected $fillable = [
        'user_id',
        'payment_method_id',
        'payment_title',
        'holder_name',
        'cc_last4',
        'registration_id',
        'is_default'
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


    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod','payment_method_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    /**
     * Get the Default Status.
     *
     * @param  string  $value
     * @return string
     */
    public function getIsDefaultAttribute($value)
    {
        return $value ? 'Yes': 'No';
    }


}
