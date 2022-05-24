<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sender_id')->unsigned()->index();
            $table->bigInteger('receiver_id')->unsigned()->index();
            $table->bigInteger('trip_id')->unsigned()->index();
            $table->enum('message_type',['A','C'])->default('C')->comment('A: Admin side, C: Customer side.');
            $table->text('message');
            $table->enum('status',['0','1','2'])->default('0')->comment('0: New, 1: Delivered , 2: Seen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
