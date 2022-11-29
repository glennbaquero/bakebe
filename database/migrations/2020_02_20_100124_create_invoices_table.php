<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cart_id')->unsigned()->index();
            $table->integer('branch_id')->unsigned()->index()->nullable();
            $table->integer('user_id')->unsigned()->index();
            $table->decimal('total_payment', 9, 2)->default(0);
            $table->string('reference_number');
            $table->integer('payment_type'); // 0 - paypal, 1 - paynamics, 2 - paymaya
            $table->string('payment_code')->nullable();
            $table->integer('status')->default(0); // 0 - false, 1 - true or complete
            $table->boolean('is_paid')->default(false); // 0 - false, 1 - true or complete
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
        Schema::dropIfExists('invoices');
    }
}
