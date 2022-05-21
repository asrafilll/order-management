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

class UpdateReturnOrderItemTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_update_return_order_item()
    {
        /** @var Order */
        $order = (new OrderBuilder)
            ->addItems()
            ->setItemQuantity(10)
            ->addPaymentMethod()
            ->addShipping()
            ->addShippingDetail()
            ->addSales()
            ->addCreator()
            ->addPacker()
            ->setStatus(OrderStatusEnum::completed())
            ->build();

        /** @var ReturnOrderItem */
        $returnOrderItem = ReturnOrderItem::create([
            'order_id' => $order->id,
            'order_item_id' => $order->items->first()->id,
            'quantity' => 1,
            'reason' => 'Lorem ipsum',
        ]);

        $input = [
            'quantity' => 2,
            'reason' => 'Lorem',
            'publish' => 1,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_order_items()
                )
            )
            ->put(route('return-order-items.update', $returnOrderItem), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $returnOrderItem->refresh();
        $this->assertEquals(2, $returnOrderItem->quantity);
        $this->assertEquals('Lorem', $returnOrderItem->reason);
        $this->assertNotNull($returnOrderItem->published_at);
    }

    /**
     * @dataProvider invalidProvider
     * @param callable $input
     * @param array $errors
     * @return void
     */
    public function test_should_error_update_return_order_item(
        callable $input,
        array $errors
    ) {
        /** @var Order */
        $order = (new OrderBuilder)
            ->addItems()
            ->setItemQuantity(1)
            ->addPaymentMethod()
            ->addShipping()
            ->addShippingDetail()
            ->addSales()
            ->addCreator()
            ->addPacker()
            ->setStatus(OrderStatusEnum::completed())
            ->build();

        /** @var ReturnOrderItem */
        $returnOrderItem = ReturnOrderItem::create([
            'order_id' => $order->id,
            'order_item_id' => $order->items->first()->id,
            'quantity' => 1,
            'reason' => 'Lorem ipsum',
        ]);

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_order_items()
                )
            )
            ->put(route('return-order-items.update', $returnOrderItem), $input());

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
                        'reason' => null,
                        'quantity' => null,
                        'publish' => null,
                    ];
                },
                [
                    'quantity',
                ],
            ],
            'all fields null, quantity: 0' => [
                function () {
                    return [
                        'reason' => null,
                        'quantity' => 0,
                        'publish' => null,
                    ];
                },
                [
                    'quantity',
                ],
            ],
            'quantity: (greater than available quantity to return)' => [
                function () {


                    return [
                        'reason' => 'Lorem',
                        'quantity' => 2,
                        'publish' => 1,
                    ];
                },
                [
                    'quantity',
                ],
            ]
        ];
    }

    /**
     * @return void
     */
    public function test_should_error_update_when_return_order_item_was_published()
    {
        /** @var Order */
        $order = (new OrderBuilder)
            ->addItems()
            ->setItemQuantity(10)
            ->addPaymentMethod()
            ->addShipping()
            ->addShippingDetail()
            ->addSales()
            ->addCreator()
            ->addPacker()
            ->setStatus(OrderStatusEnum::completed())
            ->build();

        /** @var ReturnOrderItem */
        $returnOrderItem = ReturnOrderItem::create([
            'order_id' => $order->id,
            'order_item_id' => $order->items->first()->id,
            'quantity' => 1,
            'reason' => 'Lorem ipsum',
            'published_at' => Carbon::now(),
        ]);

        $input = [
            'quantity' => 2,
            'reason' => 'Lorem',
            'publish' => 1,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_order_items()
                )
            )
            ->put(route('return-order-items.update', $returnOrderItem), $input);

        $response->assertForbidden();
    }

    /**
     * @return void
     */
    public function test_should_error_update_when_quantity_greater_than_order_item_quantity_added_with_existing_return_order_item_and_value_is_non_zero()
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

        /** @var ReturnOrderItem */
        $returnOrderItem = ReturnOrderItem::create([
            'order_id' => $order->id,
            'order_item_id' => $order->items->first()->id,
            'quantity' => 1,
            'reason' => 'Lorem ipsum',
        ]);

        /** @var ReturnOrderItem */
        $existingReturnOrderItem = $returnOrderItem->replicate();
        $existingReturnOrderItem->save();

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_order_items()
                )
            )
            ->put(route('return-order-items.update', $returnOrderItem), [
                'quantity' => 2,
                'reason' => 'Lorem',
                'publish' => 1,
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['quantity']);
    }
}
