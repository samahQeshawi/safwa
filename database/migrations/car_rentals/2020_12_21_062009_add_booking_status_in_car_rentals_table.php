<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookingStatusInCarRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_rentals', function (Blueprint $table) {
            $table->enum('booking_status', ['New', 'In progress', 'Confirmed','Cancelled'])->default('New');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_rentals', function (Blueprint $table) {
            $table->dropColumn(['booking_status']);
        });
    }
}
