<?php

namespace Tests\Feature\Order\Item;

use App\Enums\OrderStatusEnum;
use App\Enums\PermissionEnum;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderSource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\OrderFactory;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class DeleteOrderItemTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;
    use OrderFactory;

    /**
     * @return void
     */
    public function test_should_success_delete_order_item()
    {
        $order = $this->createOrder();
        $orderItem = $order->items->first();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->delete(route('orders.items.destroy', [
                $order,
                $orderItem,
            ]));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing((new OrderItem()), [
            'id' => $orderItem->id,
        ]);

        $order->refresh();

        $this->assertEquals(0, $order->items_quantity);
        $this->assertEquals(0, $order->items_price);
        $this->assertEquals(0, $order->total_price);
    }

    /**
     * @return void
     */
    public function test_should_error_delete_order_item_when_order_status_not_editable()
    {
        $order = $this->createOrder(OrderStatusEnum::processed());
        $orderItem = $order->items->first();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->delete(route('orders.items.destroy', [
                $order,
                $orderItem,
            ]));

        $response->assertForbidden();
    }

    /**
     * @return void
     */
    public function test_should_error_delete_order_item_when_order_item_order_id_not_equals_with_order_id()
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

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->delete(route('orders.items.destroy', [
                $otherOrder,
                $orderItem,
            ]));

        $response->assertForbidden();
    }
}
