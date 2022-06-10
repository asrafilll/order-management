<?php

namespace Tests\Feature\ReturnOrder;

use App\Enums\PermissionEnum;
use App\Models\Order;
use App\Models\ReturnOrder;
use App\Models\ReturnOrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\OrderBuilder;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class DeleteTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_delete_data()
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
            ->delete(route('return-orders.destroy', $returnOrder));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing($returnOrder->getTable(), [
            'id' => $returnOrder->id,
        ]);

        $this->assertDatabaseMissing($returnOrderItem->getTable(), [
            'id' => $returnOrderItem->id,
        ]);
    }
}
