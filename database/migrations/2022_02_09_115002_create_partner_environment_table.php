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
            $table->string('url', '500');
            $table->string('username')->default(null);
            $table->string('password')->default(null);
            $table->string('api_key', 500)->default(null);
            $table->string('api_token', 1000)->default(null);
            $table->string('host' )->default(null);
            $table->string('port')->default(null);
            $table->string('protocol')->default(null);
            $table->string('database')->default(null);
            $table->string('layout_check')->default(null);
            $table->string('layout_redeem')->default(null);
            $table->string('action')->default(null);
            $table->string('get_balance_script')->default(null);
            $table->string('get_redeem_script')->default(null);
            $table->string('type')->default(null);
            $table->string('partner_inc')->default(null);
            $table->string('partner_code')->default(null);
            $table->string('user_id')->default(null);
            $table->string('c_user_id')->default(null);
            $table->string('check_redeem_url', 500)->default(null);
            $table->string('redeem_url', 500)->default(null);
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
