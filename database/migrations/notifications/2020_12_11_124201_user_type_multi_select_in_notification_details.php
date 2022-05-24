<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserTypeMultiSelectInNotificationDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification_details', function (Blueprint $table) {
            $table->set('user_type_id',['2','3','4','5'])->after('format')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notification_details', function (Blueprint $table) {
            $table->dropColumn(['user_type_id']);
        });
    }
}
