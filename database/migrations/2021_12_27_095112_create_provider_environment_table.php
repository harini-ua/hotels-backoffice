<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderEnvironmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_environment', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provider_id')->unsigned();
            $table->bigInteger('environment_id')->unsigned();
            $table->boolean('status');
            $table->string('username');
            $table->string('password');
            $table->string('client_agent_id');
            $table->mediumInteger('timeout');
            $table->string('affiliation');
            $table->string('user_code');
            $table->string('api_key');
            $table->string('api_secret');
            $table->mediumText('search_endpoint');
            $table->mediumText('recheck_endpoint');
            $table->mediumText('pre_reservation_endpoint');
            $table->mediumText('booking_endpoint');
            $table->mediumText('location_countries_endpoint');
            $table->mediumText('rate_comments_endpoint');
            $table->timestamps();

            $table->foreign('provider_id')
                ->references('id')->on('providers');
            $table->foreign('environment_id')
                ->references('id')->on('environments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_environment');
    }
}
