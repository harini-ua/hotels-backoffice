<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_messages', function (Blueprint $table) {
            $table->id();
            $table->string('headline');
            $table->string('content');
            $table->string('image')->nullable();
            $table->string('status')->default(\App\Enums\PromoMessageStatus::InActive);
            $table->boolean('translateable');
            $table->boolean('show_all_company');
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('creator_id');
            $table->string('expiry_date');
            $table->timestamps();

            $table->foreign('language_id')->references('id')->on('languages');
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
        Schema::dropIfExists('promo_messages');
    }
}
