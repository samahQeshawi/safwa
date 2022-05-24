<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatlngTrips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->decimal('from_location_lat',10,7)->after('from_location');
            $table->decimal('from_location_lng',10,7)->after('from_location_lat');
            $table->decimal('to_location_lat',10,7)->after('to_location');
            $table->decimal('to_location_lng',10,7)->after('to_location_lat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['from_location_lat','from_location_lng','to_location_lat','to_location_lng']);
        });
    }
}
