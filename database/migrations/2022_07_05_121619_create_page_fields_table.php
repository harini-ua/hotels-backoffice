<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('name');
            $table->tinyInteger('type')->default(0)
                ->comment('0 => text field, 1=> text area, 2=>button, 3 => HTML content');
            $table->smallInteger('max_length')->default(30)
                ->comment('maximum character length for the field name');
            $table->tinyInteger('is_mobile')->default(0)
                ->comment('0 => Existing verbals, 1 => Web2 Verbals, 2 => Mobile Verbals');
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('pages');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_fields');
    }
}
