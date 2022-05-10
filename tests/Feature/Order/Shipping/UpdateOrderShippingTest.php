<?php

namespace Tests\Feature\Order\Shipping;

use App\Enums\OrderStatusEnum;
use App\Enums\PermissionEnum;
use App\Models\Shipping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\OrderBuilder;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class UpdateOrderShippingTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_update_order_shipping()
    {
        $order = (new OrderBuilder)->addItems()->build();
        /** @var Shipping */
        $shipping = Shipping::factory()->create();
        $input = [
            'shipping_id' => $shipping->id,
            'shipping_name' => $shipping->name,
            'shipping_price' => 10000,
            'shipping_discount' => 5000,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.shipping.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $order->refresh();

        $this->assertEquals($shipping->id, $order->shipping_id);
        $this->assertEquals($shipping->name, $order->shipping_name);
        $this->assertEquals(10000, $order->shipping_price);
        $this->assertEquals(5000, $order->shipping_discount);
        $this->assertEquals((intval($order->items_price) - intval($order->items_discount)) + (10000 - 5000), $order->total_price);
    }

    /**
     * @return void
     */
    public function test_should_error_update_order_shipping_when_order_is_not_editable()
    {
        $order = (new OrderBuilder)->setStatus(OrderStatusEnum::processed())->addItems()->build();
        /** @var Shipping */
        $shipping = Shipping::factory()->create();
        $input = [
            'shipping_id' => $shipping->id,
            'shipping_name' => $shipping->name,
            'shipping_price' => 10000,
            'shipping_discount' => 5000,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.shipping.update', $order), $input);

        $response->assertForbidden();
    }

    /**
     * @dataProvider invalidProvider
     * @param array $input
     * @param array $errors
     * @return void
     */
    public function test_should_error_update_order_shipping_when_request_data_is_invalid(
        array $input,
        array $errors
    ) {
        $order = (new OrderBuilder)->addItems()->build();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.shipping.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
    }

    public function invalidProvider()
    {
        return [
            'all fields null' => [
                [
                    'shipping_id' => null,
                    'shipping_name' => null,
                    'shipping_price' => null,
                    'shipping_discount' => null,
                ],
                [
                    'shipping_id',
                    'shipping_name',
                    'shipping_price',
                ],
            ],
            'shipping_id: (not exists), shipping_price: (not number), shipping_discount: (not number)' => [
                [
                    'shipping_id' => 0,
                    'shipping_name' => 'Sample Shipping',
                    'shipping_price' => 'some-string',
                    'shipping_discount' => 'some-string',
                ],
                [
                    'shipping_id',
                    'shipping_price',
                    'shipping_discount',
                ],
            ]
        ];
    }
}
