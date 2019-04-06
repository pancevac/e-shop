<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubtotalPriceOnOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('total_price');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal_price')->after('coupon_id');
            $table->decimal('total_price')->after('coupon_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal_price', 'total_price']);
            $table->integer('total_price')->after('coupon_id');
        });
    }
}
