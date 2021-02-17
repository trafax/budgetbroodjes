<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_product', function (Blueprint $table) {
            $table->unsignedBigInteger('extra_id');
            //$table->foreign('extra_id')->references('id')->on('extras');
            $table->unsignedBigInteger('product_id');
            //$table->foreign('product_id')->references('id')->on('products');
            $table->integer('foodticket_id')->nullable();
            $table->string('title');
            $table->decimal('price')->default(0);
            $table->integer('sort')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_product');
    }
}
