<?php

namespace Tests\Feature\Order;

use App\Enums\PermissionEnum;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_create_order()
    {
        $this->markTestIncomplete();
        $input = [
            'name' => 'Order #1',
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->post(route('orders.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas((new Order())->getTable(), $input);
    }

    /**
     * @return void
     */
    public function test_should_error_create_order()
    {
        $this->markTestIncomplete();
        $input = [
            'name' => null,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->post(route('orders.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['name']);
    }
}
