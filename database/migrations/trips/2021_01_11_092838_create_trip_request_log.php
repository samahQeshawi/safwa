<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripRequestLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_request_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('trip_id')->index();
            $table->integer('user_id')->index()->comment('The primary key of the users table of the driver');
            $table->boolean('status')->default(0)->comment('default 0 when a trip is received and updated to 1 when it is accepted');
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
        Schema::dropIfExists('trip_request_logs');
    }
}
