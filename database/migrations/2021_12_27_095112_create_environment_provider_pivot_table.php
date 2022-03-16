<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvironmentProviderPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('environment_provider', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('environment_id');
            $table->unsignedBigInteger('provider_id');
            $table->boolean('status')->default(0);
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('client_agent_id')->nullable();
            $table->mediumInteger('timeout')->nullable();
            $table->string('affiliation')->nullable();
            $table->string('user_code')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();
            $table->string('main_endpoint', 1000)->nullable();
            $table->string('search_endpoint', 1000)->nullable();
            $table->string('recheck_endpoint', 1000)->nullable();
            $table->string('pre_reservation_endpoint', 1000)->nullable();
            $table->string('booking_endpoint', 1000)->nullable();
            $table->string('location_countries_endpoint', 1000)->nullable();
            $table->string('rate_comments_endpoint', 1000)->nullable();
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
        Schema::dropIfExists('environment_provider');
    }
}
