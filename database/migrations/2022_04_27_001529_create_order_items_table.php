<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table
                ->foreignId('order_id')
                ->constrained()
                ->cascadeOnUpdate();
            $table->unsignedBigInteger('product_id');
            $table->string('product_slug');
            $table->string('product_name');
            $table->longText('product_description')->nullable();
            $table->unsignedBigInteger('variant_id');
            $table->string('variant_name');
            $table->unsignedBigInteger('variant_price');
            $table->unsignedBigInteger('variant_weight');
            $table->string('variant_option1');
            $table->string('variant_value1');
            $table->string('variant_option2')->nullable();
            $table->string('variant_value2')->nullable();
            $table->unsignedBigInteger('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
