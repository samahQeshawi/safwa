<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDecimalFeilds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->decimal('coupon_discount_percentage', $precision = 8, $scale = 2)->nullable()->change();
            $table->decimal('coupon_max_discount_amount', $precision = 8, $scale = 2)->nullable()->change();
            $table->decimal('coupon_discount_amount', $precision = 8, $scale = 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            //
        });
    }
}
