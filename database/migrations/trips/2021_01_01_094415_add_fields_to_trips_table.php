<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->integer('payment_method_id')->unsigned()->index()->after('payment_method');
            $table->string('card_user_name')->nullable()->after('payment_method_id');
            $table->string('card_number', 20)->nullable()->after('card_user_name');
            $table->date('expiry_date')->nullable()->after('card_number');
            $table->string('cvv',50)->nullable()->after('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['payment_method_id','card_user_name','card_number','expiry_date','cvv']);
        });
    }
}
