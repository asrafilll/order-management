<?php

namespace Tests\Feature\ReturnOrder;

use App\Enums\PermissionEnum;
use App\Models\Order;
use App\Models\ReturnOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\OrderBuilder;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrieveEditPageTest extends TestCase
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
        $order = (new OrderBuilder)
            ->addItems()
            ->build();

        /** @var ReturnOrder */
        $returnOrder = ReturnOrder::factory()
            ->state(['order_id' => $order->id])
            ->create();

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_orders()
                )
            )
            ->get(route('return-orders.edit', $returnOrder));

        $response->assertOk();
        $this->assertHtmlResponse($response);
    }
}
