<?php

namespace Tests\Feature\OrderSource;

use App\Enums\PermissionEnum;
use App\Models\OrderSource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class CreateOrderSourceTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_create_shipping()
    {
        $input = [
            'name' => 'Order Source #1',
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_order_sources()
                )
            )
            ->post(route('order-sources.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas((new OrderSource())->getTable(), $input);
    }

    /**
     * @return void
     */
    public function test_should_error_create_shipping()
    {
        $input = [
            'name' => null,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_order_sources()
                )
            )
            ->post(route('order-sources.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['name']);
    }
}
