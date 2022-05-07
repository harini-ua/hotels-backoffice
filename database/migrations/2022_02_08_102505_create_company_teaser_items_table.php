<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTeaserItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_teaser_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teaser_id');
            $table->integer('type')->default(\App\Enums\TeaserType::Default);
            $table->string('image')->nullable();
            $table->string('title');
            $table->text('text');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('teaser_id')->references('id')->on('company_teasers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_teaser_items');
    }
}
