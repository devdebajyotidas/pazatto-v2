<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->string('account_type');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('landmark')->default('');
            $table->string('apartment')->default('');
            $table->string('building')->default('');
            $table->string('street')->default('');
            $table->string('locality')->default('');
            $table->string('city')->default('');
            $table->string('state')->default('');
            $table->string('postal_code')->default('');
            $table->string('formatted_address')->default('');
            $table->integer('is_primary')->default(0);
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
        Schema::dropIfExists('addresses');
    }
}
