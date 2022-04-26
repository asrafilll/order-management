<?php

namespace Tests\Feature\Shipping;

use App\Enums\PermissionEnum;
use App\Models\Shipping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class UpdateShippingTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_update_shipping()
    {
        /** @var Shipping */
        $shipping = Shipping::factory()->create();
        $input = [
            'name' => 'Updated Shipping'
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_shippings()
                )
            )
            ->put(route('shippings.update', $shipping), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas($shipping->getTable(), $input);
    }

    /**
     * @return void
     */
    public function test_should_error_update_shipping()
    {
        /** @var Shipping */
        $shipping = Shipping::factory()->create();
        $input = [
            'name' => null
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_shippings()
                )
            )
            ->put(route('shippings.update', $shipping), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['name']);
    }

    /**
     * @return void
     */
    public function test_should_error_when_not_found()
    {
        $input = [
            'name' => 'Updated Shipping'
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_shippings()
                )
            )
            ->put(route('shippings.update', ['shipping' => 0]), $input);

        $response->assertNotFound();
    }
}
