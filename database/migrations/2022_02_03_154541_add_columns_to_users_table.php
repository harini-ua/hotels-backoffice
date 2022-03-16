<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('title')->after('id');
            $table->string('firstname')->after('title');
            $table->string('lastname')->after('firstname');
            $table->string('company_name')->after('password');
            $table->string('phone')->after('company_name');
            $table->unsignedBigInteger('country_id')->after('phone');
            $table->unsignedBigInteger('city_id')->after('country_id');
            $table->text('address')->after('city_id');
            $table->boolean('status')->after('address')->comment('0-inactive, 1-active');
            $table->boolean('newsletter')->after('status');
            $table->unsignedBigInteger('currency_id')->after('newsletter');
            $table->unsignedBigInteger('language_id')->after('currency_id');
            $table->dateTime('last_login_at')->nullable()->after('language_id');
            $table->ipAddress('ip_address')->nullable()->after('last_login_at');

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('language_id')->references('id')->on('languages');
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
            //
        });
    }
}
