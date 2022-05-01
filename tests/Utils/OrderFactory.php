<?php

namespace Tests\Utils;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderSource;
use App\Models\ProductVariant;
use League\CommonMark\Node\Query\OrExpr;

trait OrderFactory
{
    public function createOrder(?OrderStatusEnum $orderStatusEnum = null): Order
    {
        /** @var OrderSource */
        $orderSource = OrderSource::factory()->create();
        /** @var Customer */
        $customer = Customer::factory()->create();
        /** @var Order */
        $order = Order::create([
            'source_id' => $orderSource->id,
            'source_name' => $orderSource->name,
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_phone' => $customer->phone,
            'customer_address' => $customer->address,
            'customer_province' => $customer->province,
            'customer_city' => $customer->city,
            'customer_subdistrict' => $customer->subdistrict,
            'customer_village' => $customer->village,
            'customer_postal_code' => $customer->postal_code,
            'status' => $orderStatusEnum ?? OrderStatusEnum::waiting(),
        ]);

        /** @var Product */
        $product = Product::factory()->create();
        $product
            ->options()
            ->create([
                'name' => 'Color',
                'values' => json_encode([
                    'Red',
                    'Green',
                    'Blue',
                ])
            ]);
        $product
            ->variants()
            ->createMany([
                [
                    'name' => 'Red',
                    'price' => 10000,
                    'weight' => 1000,
                    'option1' => 'Color',
                    'value1' => 'Red',
                ],
                [
                    'name' => 'Green',
                    'price' => 11000,
                    'weight' => 1100,
                    'option1' => 'Color',
                    'value1' => 'Green',
                ],
                [
                    'name' => 'Blue',
                    'price' => 11000,
                    'weight' => 1100,
                    'option1' => 'Color',
                    'value1' => 'Blue',
                ],
            ]);

        /** @var ProductVariant */
        $productVariant = ProductVariant::with(['product'])
            ->inRandomOrder()
            ->first();

        $order
            ->items()
            ->create([
                'product_id' => $productVariant->product_id,
                'product_slug' => $productVariant->product->slug,
                'product_name' => $productVariant->product->name,
                'product_description' => $productVariant->product->description,
                'variant_id' => $productVariant->id,
                'variant_name' => $productVariant->name,
                'variant_price' => $productVariant->price,
                'variant_weight' => $productVariant->weight,
                'variant_option1' => $productVariant->option1,
                'variant_value1' => $productVariant->value1,
                'variant_option2' => $productVariant->option2,
                'variant_value2' => $productVariant->value2,
                'quantity' => 1,
            ]);

        $order->refresh();

        return $order;
    }

    public function createOrderWithoutOrderItems(?OrderStatusEnum $orderStatusEnum = null): Order
    {
        /** @var Product */
        $product = Product::factory()->create();
        $product
            ->options()
            ->create([
                'name' => 'Color',
                'values' => json_encode([
                    'Red',
                    'Green',
                    'Blue',
                ])
            ]);
        $product
            ->variants()
            ->createMany([
                [
                    'name' => 'Red',
                    'price' => 10000,
                    'weight' => 1000,
                    'option1' => 'Color',
                    'value1' => 'Red',
                ],
                [
                    'name' => 'Green',
                    'price' => 11000,
                    'weight' => 1100,
                    'option1' => 'Color',
                    'value1' => 'Green',
                ],
                [
                    'name' => 'Blue',
                    'price' => 11000,
                    'weight' => 1100,
                    'option1' => 'Color',
                    'value1' => 'Blue',
                ],
            ]);

        /** @var OrderSource */
        $orderSource = OrderSource::factory()->create();
        /** @var Customer */
        $customer = Customer::factory()->create();
        /** @var Order */
        $order = Order::create([
            'source_id' => $orderSource->id,
            'source_name' => $orderSource->name,
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_phone' => $customer->phone,
            'customer_address' => $customer->address,
            'customer_province' => $customer->province,
            'customer_city' => $customer->city,
            'customer_subdistrict' => $customer->subdistrict,
            'customer_village' => $customer->village,
            'customer_postal_code' => $customer->postal_code,
            'status' => $orderStatusEnum ?? OrderStatusEnum::waiting(),
        ]);

        $order->refresh();

        return $order;
    }
}
