<?php

namespace Tests\Feature\Shipping;

use App\Enums\PermissionEnum;
use App\Models\Shipping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrieveEditShippingPageTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        /** @var Shipping */
        $shipping = Shipping::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_shippings()
                )
            )
            ->get(route('shippings.edit', $shipping));

        $response->assertOk();
        $this->assertHtmlResponse($response);
    }

    /**
     * @return void
     */
    public function test_should_error_when_not_found()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_shippings()
                )
            )
            ->get(route('shippings.edit', ['shipping' => '0']));

        $response->assertNotFound();
    }
}
