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
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('environment_id');
            $table->boolean('status')->default(0);
            $table->string('username')->default(null);
            $table->string('password')->default(null);
            $table->string('client_agent_id')->default(null);
            $table->mediumInteger('timeout')->default(null);
            $table->string('affiliation')->default(null);
            $table->string('user_code')->default(null);
            $table->string('api_key')->default(null);
            $table->string('api_secret')->default(null);
            $table->string('search_endpoint', 1000)->default(null);
            $table->string('recheck_endpoint', 1000)->default(null);
            $table->string('pre_reservation_endpoint', 1000)->default(null);
            $table->string('booking_endpoint', 1000)->default(null);
            $table->string('location_countries_endpoint', 1000)->default(null);
            $table->string('rate_comments_endpoint', 1000)->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('environment_id')->references('id')->on('environments');
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
