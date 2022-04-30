<?php

namespace Tests\Feature\Order\Item;

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
use Tests\Utils\OrderFactory;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class UpdateOrderItemTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;
    use OrderFactory;

    /**
     * @return void
     */
    public function test_should_success_update_order_item()
    {
        $order = $this->createOrder();
        $orderItem = $order->items->first();
        /** @var ProductVariant $productVariant */
        $productVariant = ProductVariant::with(['product'])
            ->whereId($orderItem->variant_id)
            ->first();
        $input = [
            'quantity' => 10,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.items.update', [
                $order,
                $orderItem,
            ]), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas((new OrderItem()), [
            'id' => $orderItem->id,
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
            'quantity' => 10,
        ]);

        $order->refresh();

        $this->assertEquals(10, $order->items_quantity);
        $this->assertEquals(10 * $orderItem->variant_price, $order->items_price);
        $this->assertEquals(10 * $orderItem->variant_price, $order->total_price);
    }

    /**
     * @return void
     */
    public function test_should_error_update_order_item_when_order_status_not_editable()
    {
        $order = $this->createOrder(OrderStatusEnum::processed());
        $orderItem = $order->items->first();
        /** @var ProductVariant $productVariant */
        $input = [
            'quantity' => 10,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.items.update', [
                $order,
                $orderItem,
            ]), $input);

        $response->assertForbidden();
    }

    /**
     * @return void
     */
    public function test_should_error_update_order_item_when_invalid_validation()
    {
        $order = $this->createOrder();
        $orderItem = $order->items->first();
        $input = [
            'quantity' => 0,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.items.update', [
                $order,
                $orderItem,
            ]), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors([
                'quantity',
            ]);
    }

    /**
     * @return void
     */
    public function test_should_error_update_order_item_when_order_item_order_id_not_equals_with_order_id()
    {
        $order = $this->createOrder();
        $orderItem = $order->items->first();
        /** @var OrderSource */
        $orderSource = OrderSource::factory()->create();
        /** @var Customer */
        $customer = Customer::factory()->create();
        /** @var Order */
        $otherOrder = Order::create([
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

        $input = [
            'quantity' => 10,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.items.update', [
                $otherOrder,
                $orderItem,
            ]), $input);

        $response->assertForbidden();
    }
}
