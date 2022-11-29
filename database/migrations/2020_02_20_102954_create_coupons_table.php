<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('discount', 9, 2)->default(0);
            $table->integer('discount_type')->default(0); // 0 - fixed percentage, 1 - fixed price (whole amount), 2 - buy 1 take 1, 3 - money off, 4 - percentage off
            $table->integer('status')->default(0); // 0 - unused, 1 - used, 2 - expired
            $table->date('valid_start_at'); 
            $table->date('valid_end_at');
            $table->integer('max_usage')->default(1); 
            $table->integer('max_user')->default(1); 
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
        Schema::dropIfExists('coupons');
    }
}
