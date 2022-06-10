<?php

namespace Tests\Feature\ReturnOrder\Item;

use App\Enums\PermissionEnum;
use App\Models\Order;
use App\Models\ReturnOrder;
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

        $orderItemId = $order->items->first()->id;

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
            ->assertSessionHasNoErrors();

        $this->assertEquals($orderItemId, $order->items->first()->id);
    }

    /**
     * @return void
     */
    public function test_should_error_when_item_already_created()
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
}
