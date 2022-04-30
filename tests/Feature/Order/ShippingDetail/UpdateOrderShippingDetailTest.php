<?php

namespace Tests\Feature\Order\ShippingDetail;

use Tests\TestCase;
use Tests\Utils\UserFactory;
use App\Enums\PermissionEnum;
use App\Enums\OrderStatusEnum;
use Tests\Utils\ResponseAssertion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\Utils\OrderFactory;

class UpdateOrderShippingDetailTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;
    use OrderFactory;

    /**
     * @return void
     */
    public function test_should_success_update_order_shipping_detail()
    {
        $order = $this->createOrder();
        $shippingDate = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        $input = [
            'shipping_date' => $shippingDate,
            'shipping_airwaybill' => 'ASDF1234',
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.shipping-detail.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $order->refresh();

        $this->assertEquals($shippingDate, $order->shipping_date->format('Y-m-d H:i:s'));
        $this->assertEquals('ASDF1234', $order->shipping_airwaybill);
    }

    /**
     * @return void
     */
    public function test_should_error_update_order_shipping_detail_when_order_is_not_editable()
    {
        $order = $this->createOrder(OrderStatusEnum::processed());
        $shippingDate = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        $input = [
            'shipping_date' => $shippingDate,
            'shipping_airwaybill' => 'ASDF1234',
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.shipping-detail.update', $order), $input);

        $response->assertForbidden();
    }

    /**
     * @dataProvider invalidProvider
     * @param array $input
     * @param array $errors
     * @return void
     */
    public function test_should_error_update_order_shipping_detail_when_request_data_is_invalid(
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
            ->put(route('orders.shipping-detail.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
    }

    public function invalidProvider()
    {
        return [
            'all fields null' => [
                [
                    'shipping_date' => null,
                    'shipping_airwaybill' => null,
                ],
                [
                    'shipping_date',
                    'shipping_airwaybill',
                ],
            ],
            'shipping_date: (format not Y-m-d H:i:s)' => [
                [
                    'shipping_name' => date('d/m/Y H:i'),
                    'shipping_airwaybill' => 'ASDF1234',
                ],
                [
                    'shipping_date',
                ],
            ]
        ];
    }
}
