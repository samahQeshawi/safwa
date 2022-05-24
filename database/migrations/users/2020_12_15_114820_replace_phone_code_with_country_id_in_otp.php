<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplacePhoneCodeWithCountryIdInOtp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('otps', function (Blueprint $table) {
            $table->renameColumn('phone_code', 'country_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('otps', function (Blueprint $table) {
            $table->renameColumn('country_id','phone_code');
        });
    }
}
