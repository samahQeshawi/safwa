<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('place_id')->nullable();
            $table->string('coupon_name',255);
            $table->string('coupon_code',255);
            $table->decimal('coupon_reward', $precision = 8, $scale = 2)->nullable();
            $table->smallInteger('coupon_limit')->nullable();
            $table->dateTime('coupon_from_date')->useCurrent();
            $table->dateTime('coupon_to_date');
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('coupons');
    }
}
