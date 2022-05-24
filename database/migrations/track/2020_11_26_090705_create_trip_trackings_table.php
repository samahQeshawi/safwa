<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_trackings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('trip_id')->unsigned()->index();
            $table->decimal('lat',10,7);
            $table->decimal('lng',10,7);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('trip_trackings');
    }
}
