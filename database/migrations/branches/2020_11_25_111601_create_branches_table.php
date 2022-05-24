<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',300);
            $table->text('address')->nullable();
            $table->string('phone',20);
            $table->string('email',500);
            $table->string('branch_code',50);
            $table->bigInteger('country_id')->unsigned()->index();
            $table->bigInteger('city_id')->unsigned()->index();
            $table->string('longitude',50)->nullable();
            $table->string('latitude',50)->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
}
