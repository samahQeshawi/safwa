<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_reports', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code',20);
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('service_id')->unsigned()->index();
            $table->integer('applied_for_id');
            $table->timestamp('applied_on')->nullable();
            $table->decimal('total_amount',10,2);
            $table->decimal('coupon_discount_amount',10,2);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('coupon_reports');
    }
}
