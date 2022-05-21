<?php

namespace Tests\Feature\ReturnOrderItem;

use App\Enums\OrderStatusEnum;
use App\Enums\PermissionEnum;
use App\Models\Order;
use App\Models\ReturnOrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Tests\Utils\OrderBuilder;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class CreateReturnOrderItemTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_create_return_order_item_with_reason_null_and_publish_true()
    {
        /** @var Order */
        $order = (new OrderBuilder)
            ->addItems()
            ->addPaymentMethod()
            ->addShipping()
            ->addShippingDetail()
            ->addSales()
            ->addCreator()
            ->addPacker()
            ->setStatus(OrderStatusEnum::completed())
            ->build();

        $input = [
            'order_id' => $order->id,
            'order_item_id' => $order->items->first()->id,
            'reason' => null,
            'quantity' => 1,
            'publish' => 1,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_order_items()
                )
            )
            ->post(route('return-order-items.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        /** @var ReturnOrderItem */
        $returnOrderItem = ReturnOrderItem::first();
        $this->assertEquals($order->id, $returnOrderItem->order_id);
        $this->assertEquals($order->items->first()->id, $returnOrderItem->order_item_id);
        $this->assertEquals(1, $returnOrderItem->quantity);
        $this->assertNull($returnOrderItem->reason);
        $this->assertNotNull($returnOrderItem->published_at);
    }

    /**
     * @dataProvider invalidProvider
     * @param callable $input
     * @param array $errors
     * @return void
     */
    public function test_should_error_create_return_order_item(
        callable $input,
        array $errors
    ) {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_order_items()
                )
            )
            ->post(route('return-order-items.store'), $input());

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
            'all fields null' => [
                function () {
                    return [
                        'order_id' => null,
                        'order_item_id' => null,
                        'reason' => null,
                        'quantity' => null,
                        'publish' => null,
                    ];
                },
                [
                    'order_id',
                    'order_item_id',
                    'quantity',
                ],
            ],
            'all fields null, quantity: 0' => [
                function () {
                    return [
                        'order_id' => null,
                        'order_item_id' => null,
                        'reason' => null,
                        'quantity' => 0,
                        'publish' => null,
                    ];
                },
                [
                    'order_id',
                    'order_item_id',
                    'quantity',
                ],
            ]
        ];
    }

    /**
     * @return void
     */
    public function test_should_error_create_return_order_item_when_quantity_greater_than_order_item_quantity()
    {
        /** @var Order */
        $order = (new OrderBuilder)
            ->addItems()
            ->addPaymentMethod()
            ->addShipping()
            ->addShippingDetail()
            ->addSales()
            ->addCreator()
            ->addPacker()
            ->setStatus(OrderStatusEnum::completed())
            ->build();

        $input = [
            'order_id' => $order->id,
            'order_item_id' => $order->items->first()->id,
            'reason' => null,
            'quantity' => 10,
            'publish' => 1,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_order_items()
                )
            )
            ->post(route('return-order-items.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['quantity']);
    }

    /**
     * @return void
     */
    public function test_should_error_create_return_order_item_when_quantity_greater_than_order_item_quantity_added_with_existing_return_order_item_and_value_is_zero()
    {
        /** @var Order */
        $order = (new OrderBuilder)
            ->addItems()
            ->addPaymentMethod()
            ->addShipping()
            ->addShippingDetail()
            ->addSales()
            ->addCreator()
            ->addPacker()
            ->setStatus(OrderStatusEnum::completed())
            ->build();

        ReturnOrderItem::create([
            'order_id' => $order->id,
            'order_item_id' => $order->items->first()->id,
            'quantity' => 1,
        ]);

        $input = [
            'order_id' => $order->id,
            'order_item_id' => $order->items->first()->id,
            'reason' => null,
            'quantity' => 1,
            'publish' => 1,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_order_items()
                )
            )
            ->post(route('return-order-items.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHas('error');
    }

    /**
     * @return void
     */
    public function test_should_error_create_return_order_item_when_quantity_greater_than_order_item_quantity_added_with_existing_return_order_item_and_value_is_not_zero()
    {
        /** @var Order */
        $order = (new OrderBuilder)
            ->addItems()
            ->setItemQuantity(2)
            ->addPaymentMethod()
            ->addShipping()
            ->addShippingDetail()
            ->addSales()
            ->addCreator()
            ->addPacker()
            ->setStatus(OrderStatusEnum::completed())
            ->build();

        ReturnOrderItem::create([
            'order_id' => $order->id,
            'order_item_id' => $order->items->first()->id,
            'quantity' => 1,
        ]);

        $input = [
            'order_id' => $order->id,
            'order_item_id' => $order->items->first()->id,
            'reason' => null,
            'quantity' => 2,
            'publish' => 1,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_order_items()
                )
            )
            ->post(route('return-order-items.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['quantity']);
    }
}
