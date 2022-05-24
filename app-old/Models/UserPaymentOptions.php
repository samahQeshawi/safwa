<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPaymentOptions extends Model
{
    use HasFactory;

    protected $table = 'user_payment_options';

    protected $fillable = [
        'user_id',
        'payment_method_id',
        'payment_title',
        'is_default',
    ];


    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\Paymentmethod','payment_method_id');
    }

}
