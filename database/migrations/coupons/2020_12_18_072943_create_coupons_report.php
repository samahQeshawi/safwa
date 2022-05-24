<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsReport extends Migration
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
            $table->integer('user_id')->unsigned()->index();
            $table->integer('service_id')->unsigned()->index();
            $table->integer('applied_for_id')->unsigned()->index();
            $table->timestamp('applied_on')->nullable();
            $table->decimal('total_amount',10,2);
            $table->decimal('coupon_discount_amount',10,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupon_reports', function (Blueprint $table) {
             Schema::dropIfExists('coupon_reports');
        });
    }
}
