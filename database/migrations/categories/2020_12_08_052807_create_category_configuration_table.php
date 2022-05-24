<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_configurations', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->index()->unsigned();
            $table->decimal('minimum_charge',8,2,true);
            $table->decimal('km_charge',8,2,true);
            $table->decimal('cancellation_charge',8,2,true);
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
        Schema::dropIfExists('category_configurations');
    }
}
