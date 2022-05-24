<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReanameOtpTypoToOtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('otps', function (Blueprint $table) {
            $table->renameColumn('opt_expire_on', 'otp_expire_on');
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
            $table->renameColumn('otp_expire_on', 'opt_expire_on');
        });
    }
}
