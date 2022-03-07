<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerEnvironmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_environment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('environment_id');
            $table->boolean('status')->default(0);
            $table->string('url', '500')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('api_key', 500)->nullable();
            $table->string('api_token', 1000)->nullable();
            $table->string('host' )->nullable();
            $table->string('port')->nullable();
            $table->string('protocol')->nullable();
            $table->string('database')->nullable();
            $table->string('layout_check')->nullable();
            $table->string('layout_redeem')->nullable();
            $table->string('action')->nullable();
            $table->string('get_balance_script')->nullable();
            $table->string('get_redeem_script')->nullable();
            $table->string('type')->nullable();
            $table->string('partner_inc')->nullable();
            $table->string('partner_code')->nullable();
            $table->string('user_id')->nullable();
            $table->string('c_user_id')->nullable();
            $table->string('check_redeem_url', 500)->nullable();
            $table->string('redeem_url', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('partner_id')->references('id')->on('partners');
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
        Schema::dropIfExists('partner_environment');
    }
}
