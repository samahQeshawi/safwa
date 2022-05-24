<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsCarRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_rentals', function (Blueprint $table) {
            $table->decimal('pickup_lat',10,7)->after('pickup_on')->nullable();
            $table->decimal('pickup_lng',10,7)->after('pickup_lat')->nullable();
            $table->decimal('dropoff_lat',10,7)->after('dropoff_on')->nullable();
            $table->decimal('dropoff_lng',10,7)->after('dropoff_on')->nullable();
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
            $table->dropColumn(['pickup_lat','pickup_lng','dropoff_lat','dropoff_lng']);
        });
    }
}
