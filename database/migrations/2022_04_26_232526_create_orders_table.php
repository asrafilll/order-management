<?php

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table
                ->string('status')
                ->index()
                ->default(OrderStatusEnum::draft()->value);
            $table->unsignedBigInteger('source_id');
            $table->string('source_name');
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_address');
            $table->string('customer_province');
            $table->string('customer_city');
            $table->string('customer_subdistrict');
            $table->string('customer_village');
            $table->string('customer_postal_code');
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->string('payment_method_name')->nullable();
            $table
                ->string('payment_status')
                ->index()
                ->default(PaymentStatusEnum::unpaid());
            $table->unsignedBigInteger('shipping_id')->nullable();
            $table->string('shipping_name')->nullable();
            $table->date('shipping_date')->nullable();
            $table->string('shipping_airwaybill')->nullable();
            $table->unsignedBigInteger('items_quantity')->nullable();
            $table->unsignedBigInteger('items_price')->nullable();
            $table->unsignedBigInteger('items_discount')->nullable();
            $table->unsignedBigInteger('shipping_price')->nullable();
            $table->unsignedBigInteger('shipping_discount')->nullable();
            $table->unsignedBigInteger('total_price')->nullable();
            $table->string('note')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->string('returned_note')->nullable();
            $table->unsignedBigInteger('sales_id')->nullable();
            $table->string('sales_name')->nullable();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->string('creator_name')->nullable();
            $table->unsignedBigInteger('packer_id')->nullable();
            $table->string('packer_name')->nullable();
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
