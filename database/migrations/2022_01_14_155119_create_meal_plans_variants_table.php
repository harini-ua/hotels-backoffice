<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealPlansVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_plans_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meal_plan_id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('meal_plan_id')->references('id')->on('meal_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_plans_variants');
    }
}
