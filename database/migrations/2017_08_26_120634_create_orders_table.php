<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders',function (Blueprint $table){

            $table->increments('id');
            $table->integer('customer_id');
            $table->integer('vendor_id');
            $table->integer('agent_id')->nullable();
            $table->string('delivery_location');
            $table->string('delivery_type')->default('Home Delivery');
            $table->string('customer_note')->default('');
            $table->string('vendor_note')->default('');
            $table->double('sub_total')->default(0);
            $table->double('delivery_charge')->default(0);
            $table->double('packing_charge')->default(0);
            $table->double('tax')->default(0);
            $table->double('discount')->default(0);
            $table->double('total')->default(0);
            $table->string('payment_method')->default('COD');
            $table->integer('status')->default(1);

            $table->string('device_id')->default('');
            $table->string('offer_id')->default('');

            $table->timestamp('placed_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('preparing_at')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
