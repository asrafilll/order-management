<?php

namespace Tests\Feature\ReturnOrder;

use App\Enums\PermissionEnum;
use App\Models\Order;
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
        $order = (new OrderBuilder())
            ->addItems()
            ->build();

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_orders()
                )
            )
            ->post(route('return-orders.store'), [
                'order_id' => $order->id,
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }

    /**
     * @return void
     */
    public function test_should_error_when_order_id_not_exists()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_orders()
                )
            )
            ->post(route('return-orders.store'), [
                'order_id' => 999,
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['order_id']);
    }
}
