<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountPaymentStatusFinalAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_rentals', function (Blueprint $table) {
            $table->decimal('discount',10,2)->after('amount')->default(0);
            $table->decimal('final_amount',10,2)->after('discount');
            $table->boolean('payment_status')->default('0')->after('final_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_rentals', function (Blueprint $table) {
            $table->dropColumn(['discount', 'final_amount', 'payment_status']);
        });
    }
}
