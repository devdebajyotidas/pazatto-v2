<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_id')->nullable();
            $table->integer('item_category_id');
            $table->string('type')->default('');
            $table->string('featured_image')->default('');
            $table->string('name');
            $table->string('description')->default('');
            $table->double('price');
            $table->double('offer_price')->default(0);
            $table->double('packing_charge')->default(0);
            $table->integer('in_stock')->default(1);
            $table->integer('is_archived')->default(0);
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
        Schema::dropIfExists('items');
    }
}
