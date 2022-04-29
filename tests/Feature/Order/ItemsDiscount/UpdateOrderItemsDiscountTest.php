<?php

namespace Tests\Feature\Order\ItemsDiscount;

use App\Enums\OrderStatusEnum;
use App\Enums\PermissionEnum;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderSource;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class UpdateOrderItemsDiscountTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_update_order_items_discount()
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

        $input = [
            'items_discount' => 1000,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.items-discount.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $order->refresh();

        $this->assertEquals(1000, $order->items_discount);
    }

    /**
     * @return void
     */
    public function test_should_error_update_order_items_discount_when_order_is_not_editable()
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
            'status' => OrderStatusEnum::waiting()
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

        $input = [
            'items_discount' => 1000,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.items-discount.update', $order), $input);

        $response->assertForbidden();
    }

    /**
     * @dataProvider invalidProvider
     * @param array $input
     * @param array $errors
     * @return void
     */
    public function test_should_error_update_items_discount_when_request_data_is_invalid(
        array $input,
        array $errors
    ) {
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

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.items-discount.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
    }

    /**
     * @return array
     */
    public function invalidProvider()
    {
        return [
            'items_discount: null' => [
                [
                    'items_discount' => null,
                ],
                [
                    'items_discount'
                ],
            ],
            'items_discount: 0' => [
                [
                    'items_discount' => 0,
                ],
                [
                    'items_discount'
                ],
            ],

            'items_discount: (higher than items_price)' => [
                [
                    'items_discount' => 20000,
                ],
                [
                    'items_discount'
                ],
            ],
        ];
    }
}
