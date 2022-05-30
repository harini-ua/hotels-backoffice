<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpFilterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_filter', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 20);
            $table->string('comment');
            $table->unsignedBigInteger('creator_id');
            $table->date('expiry')->nullable();
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ip_filter');
    }
}
