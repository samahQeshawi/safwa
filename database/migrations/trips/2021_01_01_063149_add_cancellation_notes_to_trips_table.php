<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancellationNotesToTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->string('driver_cancellation_notes',500)->after('cancellation_charge')->nullable();
            $table->string('customer_cancellation_notes',500)->after('driver_cancellation_notes')->nullable();
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
            $table->dropColumn(['driver_cancellation_notes', 'customer_cancellation_notes']);
        });
    }
}
