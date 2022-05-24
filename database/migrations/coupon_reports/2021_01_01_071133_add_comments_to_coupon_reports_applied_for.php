<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentsToCouponReportsAppliedFor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupon_reports', function (Blueprint $table) {
            $table->integer('applied_for_id')->comment('The id of car rentals or trips table to know for which this coupon is applied.')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupon_reports', function (Blueprint $table) {
            //
        });
    }
}
