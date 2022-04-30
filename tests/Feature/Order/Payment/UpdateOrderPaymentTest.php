<?php

namespace Tests\Feature\Order\Payment;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PermissionEnum;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\OrderFactory;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class UpdateOrderPaymentTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;
    use OrderFactory;

    /**
     * @return void
     */
    public function test_should_success_update_order_payment()
    {
        $order = $this->createOrder();
        /** @var PaymentMethod */
        $paymentMethod = PaymentMethod::factory()->create();
        $input = [
            'payment_method_id' => $paymentMethod->id,
            'payment_method_name' => $paymentMethod->name,
            'payment_status' => PaymentStatusEnum::unpaid()->value,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.payment.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $order->refresh();

        $this->assertEquals($paymentMethod->id, $order->payment_method_id);
        $this->assertEquals($paymentMethod->name, $order->payment_method_name);
        $this->assertTrue($order->payment_status->equals(PaymentStatusEnum::unpaid()));
    }

    /**
     * @return void
     */
    public function test_should_error_update_order_payment_method_when_order_is_not_editable()
    {
        $order = $this->createOrder(OrderStatusEnum::processed());
        /** @var PaymentMethod */
        $paymentMethod = PaymentMethod::factory()->create();
        $input = [
            'payment_method_id' => $paymentMethod->id,
            'payment_method_name' => $paymentMethod->name,
            'payment_status' => PaymentStatusEnum::unpaid(),
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.payment.update', $order), $input);

        $response->assertForbidden();
    }

    /**
     * @dataProvider invalidProvider
     * @param array $input
     * @param array $errors
     * @return void
     */
    public function test_should_error_update_order_payment_method_when_request_data_is_invalid(
        array $input,
        array $errors
    ) {
        $order = $this->createOrder();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.payment.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
    }

    public function invalidProvider()
    {
        return [
            'all fields null' => [
                [
                    'payment_method_id' => null,
                    'payment_method_name' => null,
                    'payment_status' => null,
                ],
                [
                    'payment_method_id',
                    'payment_method_name',
                    'payment_status',
                ],
            ],
            'payment_method_id: (not exists), payment_status: (not number)' => [
                [
                    'payment_method_id' => 0,
                    'payment_method_name' => 'Sample PaymentMethod',
                    'payment_status' => 'some-string',
                ],
                [
                    'payment_method_id',
                    'payment_status',
                ],
            ]
        ];
    }
}
