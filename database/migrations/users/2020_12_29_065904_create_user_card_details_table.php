<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCardDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_card_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_payment_option_id')->index();
            $table->string('card_user_name')->nullable();
            $table->enum('card_type',['Mastercard','Visa','Visa Electron','RuPay','Maestro','Contactless']);
            $table->string('card_number', 20);
            $table->date('expiry_date');
            $table->string('cvv',50);
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
        Schema::dropIfExists('user_card_details');
    }
}
