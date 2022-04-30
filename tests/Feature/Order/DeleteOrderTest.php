<?php

namespace Tests\Feature\Order;

use App\Enums\OrderStatusEnum;
use App\Enums\PermissionEnum;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\OrderFactory;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class DeleteOrderTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;
    use OrderFactory;

    /**
     * @return void
     */
    public function test_should_success_delete_order()
    {
        $order = $this->createOrder();
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

    /**
     * @return void
     */
    public function test_should_error_when_order_is_not_editable()
    {
        $order = $this->createOrder(OrderStatusEnum::processed());
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->delete(route('orders.destroy', $order));

        $response->assertForbidden();
    }
}
