<?php

namespace Tests\Feature\Order;

use App\Enums\PermissionEnum;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\OrderFactory;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrieveEditOrderPageTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;
    use OrderFactory;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        /** @var Order */
        $order = $this->createOrder();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->get(route('orders.edit', $order));

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
            ->get(route('orders.edit', ['order' => '0']));

        $response->assertNotFound();
    }
}
