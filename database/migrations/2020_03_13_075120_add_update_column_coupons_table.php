<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUpdateColumnCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->boolean('is_voucher')->default(false);
            $table->integer('week_id')->default(0); // 0 - all week, 1 - weekday promo, 2 - weekend promo, 3 - birthday promo
            $table->integer('voucher_type')->nullable(); // 0 - metrodeal, 1 - klook
            $table->timestamp('usage_start_date_time')->nullable();
            $table->timestamp('usage_end_date_time')->nullable();
            $table->decimal('required_invoice_total')->default(0);
            $table->boolean('is_percentage')->default(false);
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
