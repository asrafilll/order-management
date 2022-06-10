<?php

namespace Tests\Feature\ReturnOrder\Item;

use App\Enums\PermissionEnum;
use App\Models\Order;
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
            ->addItems()
            ->build();

        /** @var ReturnOrder */
        $returnOrder = ReturnOrder::factory()
            ->state([
                'order_id' => $order->id
            ])
            ->create();

        $orderItemId = $order->items->first()->id;

        /** @var ReturnOrderItem */
        $returnOrderItem = $returnOrder->items()->create([
            'order_item_id' => $orderItemId,
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
                'quantity' => 1,
                'reason' => 'Test Reason',
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $returnOrderItem->refresh();

        $this->assertEquals(1, $returnOrderItem->quantity);
        $this->assertEquals('Test Reason', $returnOrderItem->reason);
    }
}
