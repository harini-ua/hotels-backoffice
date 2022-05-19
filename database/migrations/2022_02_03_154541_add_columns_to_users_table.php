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
            $table->renameColumn('name', 'username');
            $table->dropUnique('users_email_unique');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('title')->nullable()->after('username');
            $table->string('firstname')->nullable()->after('title');
            $table->string('lastname')->nullable()->after('firstname');
            $table->string('company_name')->nullable()->after('password');
            $table->string('phone')->nullable()->after('company_name');
            $table->unsignedBigInteger('country_id')->nullable()->after('phone');
            $table->unsignedBigInteger('city_id')->nullable()->after('country_id');
            $table->text('address')->nullable()->after('city_id');
            $table->boolean('status')->default(1)->after('address')
                ->comment('0-inactive, 1-active');
            $table->boolean('master')->default(0)->after('status')
                ->comment('0-common, 1-master');
            $table->boolean('newsletter')->nullable()->after('master');
            $table->unsignedBigInteger('currency_id')->nullable()->after('newsletter');
            $table->unsignedBigInteger('language_id')->nullable()->after('currency_id');
            $table->dateTime('last_login_at')->nullable()->after('language_id');
            $table->ipAddress('ip_address')->nullable()->after('last_login_at');

            $table->softDeletes()->after('updated_at');

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
            $table->renameColumn('username', 'name');
            $table->dropColumn([
                'title', 'firstname', 'lastname', 'company_name', 'phone', 'country_id', 'city_id', 'address', 'status',
                'newsletter', 'currency_id', 'language_id', 'last_login_at', 'ip_address'
            ]);
        });
    }
}
