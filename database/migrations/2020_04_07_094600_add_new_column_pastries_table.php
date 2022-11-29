<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnPastriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pastries', function (Blueprint $table) {
            $table->decimal('express_amount')->default(0);
            $table->decimal('regular_amount')->default(0);
            $table->decimal('additional_regular_amount')->default(0);
            $table->decimal('additional_express_amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
