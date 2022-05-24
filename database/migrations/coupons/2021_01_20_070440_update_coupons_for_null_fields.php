<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCouponsForNullFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->decimal('coupon_reward',8,2)->nullable()->change();
            $table->string('coupon_image')->collation('utf8mb4_unicode_ci')->charset('utf8mb4')->change();
            $table->string('coupon_code')->collation('utf8mb4_unicode_ci')->charset('utf8mb4')->change();
            $table->text('description')->collation('utf8mb4_unicode_ci')->charset('utf8mb4')->change();
            $table->string('coupon_name')->collation('utf8mb4_unicode_ci')->charset('utf8mb4')->change();
            $table->integer('place_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            //
        });
    }
}
