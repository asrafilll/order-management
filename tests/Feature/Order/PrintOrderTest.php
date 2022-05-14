<?php

namespace Tests\Feature\Order;

use App\Enums\PermissionEnum;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\OrderBuilder;
use Tests\Utils\UserFactory;

class PrintOrderTest extends TestCase
{
    use RefreshDatabase;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_return_stream_response()
    {
        /** @var Order */
        $order = (new OrderBuilder())
            ->addItems()
            ->addPaymentMethod()
            ->addShipping()
            ->addShippingDetail()
            ->addSales()
            ->addCreator()
            ->addPacker()
            ->build();

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->get(route('orders.show', $order));

        $response->assertOk();
    }
}
