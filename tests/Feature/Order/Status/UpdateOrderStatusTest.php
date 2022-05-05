<?php

namespace Tests\Feature\Order\Status;

use App\Enums\CustomerTypeEnum;
use App\Enums\OrderHistoryTypeEnum;
use Tests\TestCase;
use Tests\Utils\UserFactory;
use App\Enums\PermissionEnum;
use App\Enums\OrderStatusEnum;
use App\Jobs\CompleteOrder;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderHistory;
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

        $previousStatus = $order->status;
        $order->refresh();

        $this->assertEquals(OrderStatusEnum::processed(), $order->status);
        $this->assertDatabaseHas((new OrderHistory())->getTable(), [
            'type' => OrderHistoryTypeEnum::status(),
            'from' => $previousStatus,
            'to' => $order->status,
        ]);
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
        $this->assertDatabaseHas((new OrderHistory())->getTable(), [
            'type' => OrderHistoryTypeEnum::status(),
            'from' => OrderStatusEnum::sent(),
            'to' => $order->status,
        ]);
    }

    /**
     * @return void
     */
    public function test_should_update_customer_type_to_repeat_when_order_status_was_updated_to_completed_and_customer_have_two_completed_orders()
    {
        $order = $this->createOrder();
        $secondOrder = $order->replicate();
        $secondOrder->status = OrderStatusEnum::completed();
        $secondOrder->save();
        $input = [
            'status' => OrderStatusEnum::completed()->value,
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

        /** @var Customer */
        $customer = Customer::find($order->customer_id);
        $this->assertTrue($customer->type->equals(CustomerTypeEnum::repeat()));
    }

    /**
     * @return void
     */
    public function test_should_update_customer_type_to_repeat_when_order_status_was_triggered_update_to_completed_by_job_and_customer_have_two_completed_orders()
    {
        $order = $this->createOrder();
        $secondOrder = $order->replicate();
        $secondOrder->status = OrderStatusEnum::completed();
        $secondOrder->save();
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

        /** @var Customer */
        $customer = Customer::find($order->customer_id);
        $this->assertTrue($customer->type->equals(CustomerTypeEnum::repeat()));
    }

    /**
     * @return void
     */
    public function test_should_update_customer_type_to_member_when_order_status_was_updated_to_completed_and_customer_have_three_or_more_completed_orders()
    {
        $order = $this->createOrder();
        $secondOrder = $order->replicate();
        $secondOrder->status = OrderStatusEnum::completed();
        $secondOrder->save();
        $thirdOrder = $secondOrder->replicate();
        $thirdOrder->save();
        $input = [
            'status' => OrderStatusEnum::completed()->value,
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

        /** @var Customer */
        $customer = Customer::find($order->customer_id);
        $this->assertTrue($customer->type->equals(CustomerTypeEnum::member()));
    }

    /**
     * @return void
     */
    public function test_should_update_customer_type_to_member_when_order_status_was_triggered_update_to_completed_by_job_and_customer_have_three_or_more_completed_orders()
    {
        $order = $this->createOrder();
        $secondOrder = $order->replicate();
        $secondOrder->status = OrderStatusEnum::completed();
        $secondOrder->save();
        $thirdOrder = $secondOrder->replicate();
        $thirdOrder->save();
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

        /** @var Customer */
        $customer = Customer::find($order->customer_id);
        $this->assertTrue($customer->type->equals(CustomerTypeEnum::member()));
    }
}
