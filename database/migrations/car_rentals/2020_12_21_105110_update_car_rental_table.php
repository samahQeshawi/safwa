<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCarRentalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_rentals', function (Blueprint $table) {
            $table->integer('branch_id')->unsigned()->nullable()->after('car_id');
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
            $table->dropColumn('branch_id');
        });
    }
}
