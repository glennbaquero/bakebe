<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePastriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pastries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id')->index()->unsigned();
            $table->string('difficulty');
            $table->integer('duration')->default(0); // by mins regular booking
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('express_duration')->default(0); // by mins express booking
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pastries');
    }
}
