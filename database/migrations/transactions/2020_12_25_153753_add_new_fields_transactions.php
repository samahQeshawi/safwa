<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('currency',100);
            $table->string('checkout_id',250);
            $table->string('status',100);
            $table->json('data')->nullable();
            $table->json('trackable_data');
            $table->string('brand',100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['currency','checkout_id','status','data','trackable_data','brand']);
        });
    }
}
