<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_rentals', function (Blueprint $table) {
            $table->id();
            $table->string('booking_no',20);
            $table->integer('user_id')->unsigned()->index();
            $table->integer('car_id')->unsigned()->index();
            $table->timestamp('pickup_on');
            $table->integer('duration_in_days');
            $table->timestamp('dropoff_on');
            $table->decimal('amount',10,2);
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
        Schema::dropIfExists('car_rentals');
    }
}
