<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
             $table->smallInteger('coupon_limit')->unsigned()->nullable()->change();
             $table->boolean('use_percentage')->nullable()->after('coupon_name');
             $table->integer('coupon_discount_percentage')->nullable()->after('use_percentage');
             $table->integer('coupon_max_discount_amount')->nullable()->after('coupon_discount_percentage');
             $table->integer('coupon_discount_amount')->nullable()->after('coupon_max_discount_amount');
             $table->tinyInteger('coupon_type')->nullable()->after('coupon_limit');
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
            $table->text('coupon_limit')->nullable()->change();
            $table->dropColumn(['use_percentage','coupon_discount_percentage', 'coupon_max_discount_amount', 'coupon_discount_amount','coupon_type']);
        });
    }
}
