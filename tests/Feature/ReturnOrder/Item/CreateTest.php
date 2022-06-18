<?php

namespace Tests\Feature\ReturnOrder\Item;

use App\Enums\PermissionEnum;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ReturnOrder;
use App\Models\ReturnOrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\OrderBuilder;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class CreateTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_create_data()
    {
        /** @var Order */
        $order = (new OrderBuilder)
            ->addItems()
            ->build();

        /** @var ReturnOrder */
        $returnOrder = ReturnOrder::factory()
            ->state([
                'order_id' => $order->id
            ])
            ->create();

        /** @var OrderItem */
        $orderItem = $order->items->first();

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_orders()
                )
            )
            ->post(route('return-orders.items.store', $returnOrder), [
                'order_item_id' => $orderItem->id,
                'quantity' => 1,
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas((new ReturnOrderItem())->getTable(), [
            'return_order_id' => $returnOrder->id,
            'order_item_id' => $orderItem->id,
            'quantity' => 1,
        ]);

        $this->assertDatabaseHas($orderItem->getTable(), [
            'id' => $orderItem->id,
            'returned_quantity' => 1,
        ]);
    }

    /**
     * @return void
     */
    public function test_should_error_when_item_already_created()
    {
        /** @var Order */
        $order = (new OrderBuilder)
            ->setItemQuantity(2)
            ->addItems()
            ->build();

        /** @var ReturnOrder */
        $returnOrder = ReturnOrder::factory()
            ->state([
                'order_id' => $order->id
            ])
            ->create();

        $orderItemId = $order->items->first()->id;

        $returnOrder->items()->create([
            'order_item_id' => $orderItemId,
            'quantity' => 1,
        ]);

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_orders()
                )
            )
            ->post(route('return-orders.items.store', $returnOrder), [
                'order_item_id' => $orderItemId,
                'quantity' => 1,
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['order_item_id']);
    }

    /**
     * @return void
     */
    public function test_should_error_when_quantity_is_higher_than_unreturn_quantity()
    {
        /** @var Order */
        $order = (new OrderBuilder)
            ->addItems()
            ->build();

        /** @var ReturnOrder */
        $returnOrder = ReturnOrder::factory()
            ->state([
                'order_id' => $order->id
            ])
            ->create();

        /** @var OrderItem */
        $orderItem = $order->items->first();

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_orders()
                )
            )
            ->post(route('return-orders.items.store', $returnOrder), [
                'order_item_id' => $orderItem->id,
                'quantity' => 2,
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['quantity']);
    }
}
