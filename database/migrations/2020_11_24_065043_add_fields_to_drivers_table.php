<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->string('national_id', 50)->after('smart_phone_type');
            $table->string('iqama_no', 50)->after('national_id');
            $table->string('license_no', 50)->after('iqama_no');
            $table->string('national_file', 300)->after('license_no');
            $table->string('iqama_file', 300)->after('national_file');
            $table->string('license_file', 300)->after('iqama_file');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn('national_id');
            $table->dropColumn('iqama_no');
            $table->dropColumn('license_no');
            $table->dropColumn('national_file');
            $table->dropColumn('iqama_file');
            $table->dropColumn('license_file');
        });
    }
}
