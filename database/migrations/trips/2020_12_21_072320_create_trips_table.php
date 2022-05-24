<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_now_trip')->default('1');
            $table->string('trip_no', 20);
            $table->integer('service_id')->index();
            $table->integer('customer_id')->index();
            $table->integer('driver_id')->index();
            $table->integer('car_id')->index();
            $table->string('from_address');
            $table->point('from_location');
            $table->string('to_address');
            $table->point('to_location');
            $table->timestamp('pickup_on')->nullable();
            $table->timestamp('dropoff_on')->nullable();
            $table->decimal('distance',8,2)->nullable();
            $table->integer('category_id');
            $table->decimal('minimum_charge',8,2);
            $table->decimal('km_charge',8,2);
            $table->decimal('cancellation_charge',8,2);
            $table->decimal('amount',10,2)->default(0);
            $table->decimal('discount',10,2)->default(0);
            $table->decimal('tax',10,2)->default(0);
            $table->decimal('final_amount',10,2)->default(0);
            $table->string('payment_method')->nullable();
            $table->boolean('payment_status')->default('0');
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
        Schema::dropIfExists('trips');
    }
}
