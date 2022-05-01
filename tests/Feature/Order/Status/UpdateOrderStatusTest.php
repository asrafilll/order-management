<?php

namespace Tests\Feature\Order\Status;

use Tests\TestCase;
use Tests\Utils\UserFactory;
use App\Enums\PermissionEnum;
use App\Enums\OrderStatusEnum;
use App\Jobs\CompleteOrder;
use Carbon\Carbon;
use Tests\Utils\ResponseAssertion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\Utils\OrderFactory;

class UpdateOrderStatusTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;
    use OrderFactory;

    /**
     * @return void
     */
    public function test_should_success_update_order_status()
    {
        $order = $this->createOrder();
        $input = [
            'status' => OrderStatusEnum::processed()->value,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.status.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $order->refresh();

        $this->assertEquals(OrderStatusEnum::processed()->value, $order->status);
    }

    /**
     * @return void
     */
    public function test_should_success_update_order_status_to_sent_and_dispatch_complete_order_job_with_one_week_delay()
    {
        Queue::fake();

        $order = $this->createOrder();
        $input = [
            'status' => OrderStatusEnum::sent()->value,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.status.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        Queue::assertPushed(function (CompleteOrder $completeOrder) {
            /** @var Carbon */
            $delay = $completeOrder->delay;
            return intval(ceil($delay->floatDiffInDays())) === 7;
        });
    }

    /**
     * @return void
     */
    public function test_should_success_update_order_status_to_complete_when_order_status_was_sent_for_a_week()
    {
        $order = $this->createOrder();
        $input = [
            'status' => OrderStatusEnum::sent()->value,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.status.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $order->refresh();
        $this->assertTrue($order->status->equals(OrderStatusEnum::completed()));
    }
}
