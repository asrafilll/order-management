<?php

namespace Tests\Feature\Order\ItemsDiscount;

use App\Enums\OrderStatusEnum;
use App\Enums\PermissionEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\OrderFactory;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class UpdateOrderItemsDiscountTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;
    use OrderFactory;

    /**
     * @return void
     */
    public function test_should_success_update_order_items_discount()
    {
        $order = $this->createOrder();
        $input = [
            'items_discount' => 1000,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.items-discount.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $order->refresh();

        $this->assertEquals(1000, $order->items_discount);
        $this->assertEquals($order->items_price - 1000, $order->total_price);
    }

    /**
     * @return void
     */
    public function test_should_error_update_order_items_discount_when_order_is_not_editable()
    {
        $order = $this->createOrder(OrderStatusEnum::processed());
        $input = [
            'items_discount' => 1000,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.items-discount.update', $order), $input);

        $response->assertForbidden();
    }

    /**
     * @dataProvider invalidProvider
     * @param array $input
     * @param array $errors
     * @return void
     */
    public function test_should_error_update_items_discount_when_request_data_is_invalid(
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
            ->put(route('orders.items-discount.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
    }

    /**
     * @return array
     */
    public function invalidProvider()
    {
        return [
            'items_discount: null' => [
                [
                    'items_discount' => null,
                ],
                [
                    'items_discount'
                ],
            ],
            'items_discount: (higher than items_price)' => [
                [
                    'items_discount' => 20000,
                ],
                [
                    'items_discount'
                ],
            ],
        ];
    }
}
