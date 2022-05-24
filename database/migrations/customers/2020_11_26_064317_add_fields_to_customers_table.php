<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('national_id',20)->after('user_id')->nullable();
            $table->string('national_file')->after('national_id')->nullable();
            $table->string('license_no',20)->after('national_file')->nullable();
            $table->string('license_file')->after('license_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['national_id','national_file','license_no','license_file']);
        });
    }
}
