<?php

namespace Tests\Feature\Order;

use App\Enums\OrderStatusEnum;
use App\Enums\PermissionEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\OrderBuilder;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class DeleteOrderTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_delete_order()
    {
        $order = (new OrderBuilder)->addItems()->build();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->delete(route('orders.destroy', $order));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }

    /**
     * @return void
     */
    public function test_should_error_when_not_found()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->delete(route('orders.destroy', ['order' => '0']));

        $response->assertNotFound();
    }
}
