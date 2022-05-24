<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id')->unsigned()->index();
            $table->string('booking_no',20);
            $table->string('booking_code',100);
            $table->text('start_destination');
            $table->string('start_latitude',50);
            $table->string('start_longitude',50);
            $table->text('end_destination');
            $table->string('end_latitude',50);
            $table->string('end_longitude',50);
            $table->string('distance',10);
            $table->string('start_date',20);
            $table->string('start_time',10);
            $table->bigInteger('car_type_id')->unsigned()->index();
            $table->decimal('amount',8,2);
            $table->text('landmark');
            $table->text('start_address');
            $table->integer('driver_id')->unsigned()->index();
            $table->enum('status',['inprogress','completed','started','cancelled'])->default('inprogress')->comment('0: inprogress, 1: completed , 2: cancelled');
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
        Schema::dropIfExists('bookings');
    }
}
