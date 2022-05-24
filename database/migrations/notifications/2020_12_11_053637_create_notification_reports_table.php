<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_details', function (Blueprint $table) {
            $table->id();
            $table->integer('notification_id')->unsigned()->index();
            $table->set('format',['sms','push_notification']);
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('sent_by')->unsigned()->index();
            $table->timestamp('sent_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_details');
    }
}
