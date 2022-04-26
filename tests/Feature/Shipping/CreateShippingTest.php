<?php

namespace Tests\Feature\Shipping;

use App\Enums\PermissionEnum;
use App\Models\Shipping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class CreateShippingTest extends TestCase
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
            'name' => 'Shipping #1',
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_shippings()
                )
            )
            ->post(route('shippings.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas((new Shipping())->getTable(), $input);
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
                    PermissionEnum::manage_shippings()
                )
            )
            ->post(route('shippings.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['name']);
    }
}
