<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->integer('service_id')->after('branch_code')->unsigned()->index();
            $table->string('zipcode',10)->after('address')->nullable();
            $table->string('image_file')->nullable();
            // Add a Point spatial data field named location
            $table->point('location')->after('city_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn(['service_id','zipcode','image_file','location']);
        });
    }
}
