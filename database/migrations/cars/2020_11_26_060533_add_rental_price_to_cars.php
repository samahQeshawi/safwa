<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRentalPriceToCars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->decimal('rent_hourly')->after('service_id')->nullable();
            $table->decimal('rent_daily')->after('rent_hourly')->nullable();
            $table->decimal('rent_weekly')->after('rent_daily')->nullable();
            $table->decimal('rent_monthly')->after('rent_weekly')->nullable();
            $table->decimal('rent_yearly')->after('rent_monthly')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['rent_hourly','rent_daily','rent_weekly','rent_monthly','rent_yearly']);
        });
    }
}
