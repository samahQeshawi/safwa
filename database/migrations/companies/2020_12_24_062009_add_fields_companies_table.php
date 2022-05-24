<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->index()->after('id');
            $table->string('cr_no',50)->nullable()->after('user_id');
            $table->string('cr_doc',300)->nullable()->after('cr_no');
            $table->string('latitude',50)->nullable()->after('cr_doc');
            $table->string('longitude',50)->nullable()->after('latitude');
            $table->foreign('user_id')->references('id')->on('users');
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
            $table->dropColumn(['user_id','cr_no','cr_doc','latitude','longitude']);
             $table->dropForeign(['user_id']);
        });
    }
}
