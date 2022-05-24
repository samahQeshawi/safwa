<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StatusFieldsChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn('status');

        });
        Schema::table('trips', function (Blueprint $table) {
            $table->enum('status',['1','2','3','4','5','6','7','8','9','10','11'])->default('1')->after('service_id')->comment('1-New, 2-Pending, 3-No driver available, 4-Driver accepted, 5-Driver reached pickup location, 6-Trip started, 7-Reached destination, 8-Completed trip, 9-Money collected, 10-Trip cancelled by driver, 11-Trip cancelled by customer');
            $table->boolean('is_driver_rated')->default('0')->after('status');
            $table->boolean('is_customer_rated')->default('0')->after('is_driver_rated');
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
            $table->dropColumn(['is_driver_rated', 'is_customer_rated']);
        });
    }
}
