<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLatlngTripsDatatype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->string('from_location_lat',100)->change();
            $table->string('from_location_lng',100)->change();
            $table->string('to_location_lat',100)->change();
            $table->string('to_location_lng',100)->change();
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
            //$table->dropColumn(['from_location_lat','from_location_lng','to_location_lat','to_location_lng']);
        });
    }
}
