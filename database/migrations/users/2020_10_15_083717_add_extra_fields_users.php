<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname')->after('name')->nullable();
            $table->enum('gender',['Male','Female','Other'])->after('phone')->nullable();
            $table->string('profile_image')->after('user_type_id')->nullable();
            $table->integer('country_id')->after('phone')->unsigned()->index();
            $table->integer('city_id')->after('country_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['surname', 'gender', 'profile_image']);
        });
    }
}
