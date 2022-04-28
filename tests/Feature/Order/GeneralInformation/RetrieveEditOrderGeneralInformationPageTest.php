<?php

namespace Tests\Feature\Order\GeneralInformation;

use App\Enums\PermissionEnum;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrieveEditOrderGeneralInformationPageTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        /** @var Order */
        $order = Order::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->get(route('orders.general-information.edit', $order));

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
                    PermissionEnum::manage_orders()
                )
            )
            ->get(route('orders.general-information.edit', ['order' => '0']));

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_should_error_when_general_information_not_editable()
    {
        /** @var Order */
        $order = Order::factory()
            ->waiting()
            ->create();

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->get(route('orders.general-information.edit', $order));

        $response->assertForbidden();
    }
}
