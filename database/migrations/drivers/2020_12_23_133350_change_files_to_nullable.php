<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFilesToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->string('birth_certificate_file',300)->nullable()->change();
            $table->string('passport_file',300)->nullable()->change();
            $table->string('national_id',50)->nullable(false)->change();
            $table->string('national_file',300)->nullable(false)->change();
            $table->string('license_file',300)->nullable(false)->change();
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
            //
        });
    }
}
