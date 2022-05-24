<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('service_id')->unsigned()->index();
            $table->integer('branch_id')->unsigned()->index();
            $table->string('car_name');
            $table->integer('category_id')->unsigned()->index();
            $table->integer('car_type_id')->unsigned()->index();
            $table->integer('car_make_id')->unsigned()->index();
            $table->integer('fuel_type_id')->unsigned()->index();
            $table->integer('model_year')->unsigned();
            $table->integer('seats')->unsigned();
            $table->enum('transmission',['Manual','Automatic','Others'])->nullable();
            $table->string('color')->nullable();
            $table->string('engine')->nullable();
            $table->string('engine_no')->nullable();
            $table->string('short_description', 500)->nullable();
            $table->text('description')->nullable();
            $table->string('registration_no')->nullable();
            $table->date('insurance_expiry_date')->nullable();
            $table->string('registration_file')->nullable();
            $table->string('insurance_file')->nullable();
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
        Schema::dropIfExists('cars');
    }
}
