<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_id');

            $table->string('name');
            $table->string('contact_person')->default('');
            $table->string('featured_image');
            $table->string('contact_phone')->default('');
            $table->string('contact_email')->default('');
//            $table->string('address')->default('');
//            $table->string('coordinates')->default('');
            $table->double('min_order')->default(0);
            $table->double('average_cost')->default(200);
            $table->integer('has_takeaway')->default(1);
            $table->integer('has_delivery')->default(1);
            $table->integer('average_delivery_time')->default(45);
            $table->integer('free_delivery_range')->default(5);
            $table->integer('paid_delivery_range')->default(0);
            $table->double('delivery_charge')->default(0);
            $table->time('open_time')->default("10:00");
            $table->time('close_time')->default("23:00");
            $table->time('happy_hour_start')->nullable();
            $table->time('happy_hour_end')->nullable();

            $table->double('pazatto_commission')->default(0);
            $table->double('customer_commission')->default(0);
            $table->double('tax')->default(0);

            $table->integer('is_taking_orders')->default(1);
            $table->string('highlights')->default('');
            $table->string('category')->default('');

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
        Schema::dropIfExists('vendors');
    }
}
