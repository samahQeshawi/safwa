<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->integer('car_rental_id')->unsigned()->nullable();
            $table->integer('trip_id')->unsigned()->nullable();
            $table->integer('from_user_type')->unsigned()->index();
            $table->integer('against_user_type')->unsigned()->index();
            $table->integer('from_user_id')->unsigned()->index();
            $table->integer('against_user_id')->unsigned()->index();
            $table->string('subject');
            $table->text('complaint');
            $table->enum('status',['New','Read','Processing','Solved']);
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
        Schema::dropIfExists('complaints');
    }
}
