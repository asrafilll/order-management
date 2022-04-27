<?php

namespace Tests\Feature\Order;

use App\Enums\PermissionEnum;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class UpdateOrderTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_update_order()
    {
        $this->markTestIncomplete();
        /** @var Order */
        $order = Order::factory()->create();
        $input = [
            'name' => 'Updated Order'
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas($order->getTable(), $input);
    }

    /**
     * @return void
     */
    public function test_should_error_update_order()
    {
        $this->markTestIncomplete();
        /** @var Order */
        $order = Order::factory()->create();
        $input = [
            'name' => null
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['name']);
    }

    /**
     * @return void
     */
    public function test_should_error_when_not_found()
    {
        $this->markTestIncomplete();
        $input = [
            'name' => 'Updated Order'
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.update', ['order' => 0]), $input);

        $response->assertNotFound();
    }
}
