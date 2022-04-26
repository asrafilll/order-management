<?php

namespace Tests\Feature\Shipping;

use App\Enums\PermissionEnum;
use App\Models\Shipping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class DeleteShippingTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_delete_shipping()
    {
        /** @var Shipping */
        $shipping = Shipping::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_shippings()
                )
            )
            ->delete(route('shippings.destroy', $shipping));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }

    public function test_should_error_when_not_found()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_shippings()
                )
            )
            ->delete(route('shippings.destroy', ['shipping' => '0']));

        $response->assertNotFound();
    }
}
