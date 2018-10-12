<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_discounts',function (Blueprint $table){
           $table->increments('id');
           $table->integer('order_id');
           $table->text('device_id');
           $table->integer('customer_id');
           $table->integer('discount_id');
           $table->string('coupon');
           $table->double('discounted_amount');
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
        Schema::dropIfExists('order_discounts');
    }
}
