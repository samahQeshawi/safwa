<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    use HasFactory;

    protected $table = 'user_coupons';

    protected $fillable = [
        'user_id',
        'coupon_code',
        'coupon_id',
    ];


    public function coupon(){
       return $this->hasOne('\App\Models\Coupon');
    }

}
