<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts',function (Blueprint $table){
            $table->increments('id');
            $table->string('code')->default('');
            $table->string('title');
            $table->text('description');
            $table->string('type')->default('OFFER'); // OFFER or COUPON
            $table->integer('is_featured')->default(1);
            $table->string('featured_image')->default('');
            $table->integer('service_id')->default(0);
            $table->integer('vendor_id')->default(0);
            $table->integer('customer_id')->default(0);
            $table->string('discountable_model')->default('App\Models\Order');
            $table->string('discountable_type')->default('');
            $table->integer('discountable_id')->default(0);
            $table->dateTime('expires_on')->nullable();
            $table->double('min_order_amount')->default(0);
            $table->integer('quantity_required')->default(0);
            $table->integer('quantity_discounted')->default(0);
            $table->string('discount_operation')->default('%'); // '%' or '-'
            $table->double('discount_value')->default(10);
            $table->integer('is_first_order_only')->default(0);
            $table->integer('max_usage')->default(1);
//            $table->integer('max_usage_customer')->default(1);
//            $table->integer('max_usage_device')->default(1);
            $table->integer('is_active')->default(1);
            $table->integer('is_approved')->default(1);
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
        Schema::dropIfExists('discounts');
    }
}
