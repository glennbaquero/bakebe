<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cart_id')->unsigned()->index();
            $table->integer('pastry_id')->unsigned()->index();
            $table->integer('attendees')->default(1);
            $table->decimal('price_per_head', 9, 2)->default(0);
            $table->decimal('additional_fee', 9, 2)->default(0);
            $table->decimal('sub_total', 9, 2)->default(0);
            $table->decimal('grand_total', 9, 2)->default(0);
            $table->date('scheduled_date');
            $table->time('start_time');
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
        Schema::dropIfExists('cart_items');
    }
}
