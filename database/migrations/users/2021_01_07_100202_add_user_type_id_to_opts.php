<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserTypeIdToOpts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('otps', function (Blueprint $table) {
            $table->integer('user_type_id')->unsigned()->index()->after('user_id')->nullable();
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
            $table->dropColumn(['user_type_id']);
        });
    }
}
