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

class UpdateTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_update_data()
    {
        /** @var Order */
        $order = (new OrderBuilder)
            ->setItemQuantity(10)
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

        /** @var ReturnOrderItem */
        $returnOrderItem = $returnOrder->items()->create([
            'order_item_id' => $orderItem->id,
            'quantity' => 1,
        ]);

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_orders()
                )
            )
            ->put(route('return-orders.items.update', [
                'returnOrder' => $returnOrder,
                'returnOrderItem' => $returnOrderItem,
            ]), [
                'quantity' => 10,
                'reason' => 'Test Reason',
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas($returnOrderItem->getTable(), [
            'id' => $returnOrderItem->id,
            'quantity' => 10,
            'reason' => 'Test Reason',
        ]);

        $this->assertDatabaseHas($orderItem->getTable(), [
            'id' => $orderItem->id,
            'returned_quantity' => 10,
        ]);
    }

    /**
     * @return void
     */
    public function test_should_update_order_item_returned_quantity_when_item_already_partial_returned()
    {
        /** @var Order */
        $order = (new OrderBuilder)
            ->setItemQuantity(10)
            ->addItems()
            ->build();

        /** @var OrderItem */
        $orderItem = $order->items->first();

        /** @var ReturnOrder */
        $returnOrder = ReturnOrder::factory()
            ->state([
                'order_id' => $order->id
            ])
            ->create();

        /** @var ReturnOrder */
        $existingReturnOrder = $returnOrder->replicate();
        $existingReturnOrder->save();
        $existingReturnOrder->items()->create([
            'order_item_id' => $orderItem->id,
            'quantity' => 1,
        ]);

        /** @var ReturnOrderItem */
        $returnOrderItem = $returnOrder->items()->create([
            'order_item_id' => $orderItem->id,
            'quantity' => 1,
        ]);

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_orders()
                )
            )
            ->put(route('return-orders.items.update', [
                'returnOrder' => $returnOrder,
                'returnOrderItem' => $returnOrderItem,
            ]), [
                'quantity' => 5,
                'reason' => 'Test Reason',
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas($returnOrderItem->getTable(), [
            'id' => $returnOrderItem->id,
            'quantity' => 5,
            'reason' => 'Test Reason',
        ]);

        $this->assertDatabaseHas($orderItem->getTable(), [
            'id' => $orderItem->id,
            'returned_quantity' => 6,
        ]);
    }

    /**
     * @return void
     */
    public function test_should_error_when_quantity_is_higher_than_unreturn_quantity()
    {
        /** @var Order */
        $order = (new OrderBuilder)
            ->setItemQuantity(10)
            ->addItems()
            ->build();

        /** @var OrderItem */
        $orderItem = $order->items->first();

        /** @var ReturnOrder */
        $returnOrder = ReturnOrder::factory()
            ->state([
                'order_id' => $order->id
            ])
            ->create();

        /** @var ReturnOrder */
        $existingReturnOrder = $returnOrder->replicate();
        $existingReturnOrder->save();
        $existingReturnOrder->items()->create([
            'order_item_id' => $orderItem->id,
            'quantity' => 5,
        ]);

        /** @var ReturnOrderItem */
        $returnOrderItem = $returnOrder->items()->create([
            'order_item_id' => $orderItem->id,
            'quantity' => 1,
        ]);

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_orders()
                )
            )
            ->put(route('return-orders.items.update', [
                'returnOrder' => $returnOrder,
                'returnOrderItem' => $returnOrderItem,
            ]), [
                'quantity' => 6,
                'reason' => 'Test Reason',
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['quantity']);
    }
}
