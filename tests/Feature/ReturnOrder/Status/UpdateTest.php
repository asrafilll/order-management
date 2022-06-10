<?php

namespace Tests\Feature\ReturnOrder\Status;

use App\Enums\PermissionEnum;
use App\Enums\ReturnOrderStatusEnum;
use App\Models\Order;
use App\Models\ReturnOrder;
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
            ->state(['order_id' => $order->id])
            ->create();

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_orders()
                )
            )
            ->put(route('return-orders.status.update', $returnOrder), [
                'status' => ReturnOrderStatusEnum::at_warehouse()->value,
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }
}
