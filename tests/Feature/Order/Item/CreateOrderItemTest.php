<?php

namespace Tests\Feature\Order\Item;

use App\Enums\OrderStatusEnum;
use App\Enums\PermissionEnum;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\OrderFactory;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class CreateOrderItemTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;
    use OrderFactory;

    /**
     * @return void
     */
    public function test_should_success_create_order_item()
    {
        $order = $this->createOrderWithoutOrderItems();
        /** @var ProductVariant */
        $productVariant = ProductVariant::with(['product'])
            ->inRandomOrder()
            ->first();
        $input = [
            'variant_id' => $productVariant->id,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->post(route('orders.items.store', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas((new OrderItem()), [
            'product_id' => $productVariant->product_id,
            'product_slug' => $productVariant->product->slug,
            'product_name' => $productVariant->product->name,
            'product_description' => $productVariant->product->description,
            'variant_id' => $productVariant->id,
            'variant_name' => $productVariant->name,
            'variant_price' => $productVariant->price,
            'variant_weight' => $productVariant->weight,
            'variant_option1' => $productVariant->option1,
            'variant_value1' => $productVariant->value1,
            'variant_option2' => $productVariant->option2,
            'variant_value2' => $productVariant->value2,
            'quantity' => 1,
        ]);

        $order->refresh();

        $this->assertEquals(1, $order->items_quantity);
        $this->assertEquals($productVariant->price, $order->items_price);
        $this->assertEquals($productVariant->price, $order->total_price);
    }

    /**
     * @return void
     */
    public function test_should_error_create_order_item_when_order_is_not_editable()
    {
        $order = $this->createOrderWithoutOrderItems(OrderStatusEnum::waiting());
        /** @var ProductVariant */
        $productVariant = ProductVariant::with(['product'])
            ->inRandomOrder()
            ->first();
        $input = [
            'variant_id' => $productVariant->id,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->post(route('orders.items.store', $order), $input);

        $response->assertForbidden();
    }

    /**
     * @return void
     */
    public function test_should_error_create_order_item_because_product_variant_not_exists()
    {
        $order = $this->createOrderWithoutOrderItems();
        $input = [
            'variant_id' => 1,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->post(route('orders.items.store', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors([
                'variant_id',
            ]);
    }

    /**
     * @return void
     */
    public function test_should_not_create_new_order_item_when_order_item_already_exists()
    {
        $order = $this->createOrderWithoutOrderItems();
        /** @var ProductVariant */
        $productVariant = ProductVariant::with(['product'])
            ->inRandomOrder()
            ->first();
        /** @var OrderItem */
        $orderItem = $order
            ->items()
            ->create([
                'product_id' => $productVariant->product_id,
                'product_slug' => $productVariant->product->slug,
                'product_name' => $productVariant->product->name,
                'product_description' => $productVariant->product->description,
                'variant_id' => $productVariant->id,
                'variant_name' => $productVariant->name,
                'variant_price' => $productVariant->price,
                'variant_weight' => $productVariant->weight,
                'variant_option1' => $productVariant->option1,
                'variant_value1' => $productVariant->value1,
                'variant_option2' => $productVariant->option2,
                'variant_value2' => $productVariant->value2,
                'quantity' => 1,
            ]);

        $input = [
            'variant_id' => $productVariant->id,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->post(route('orders.items.store', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas((new OrderItem()), [
            'id' => $orderItem->id,
            'product_id' => $productVariant->product_id,
            'product_slug' => $productVariant->product->slug,
            'product_name' => $productVariant->product->name,
            'product_description' => $productVariant->product->description,
            'variant_id' => $productVariant->id,
            'variant_name' => $productVariant->name,
            'variant_price' => $productVariant->price,
            'variant_weight' => $productVariant->weight,
            'variant_option1' => $productVariant->option1,
            'variant_value1' => $productVariant->value1,
            'variant_option2' => $productVariant->option2,
            'variant_value2' => $productVariant->value2,
            'quantity' => 2, // +1 because already exists
        ]);

        $order->refresh();

        $this->assertEquals(2, $order->items_quantity);
        $this->assertEquals(2 * $productVariant->price, $order->items_price);
        $this->assertEquals(2 * $productVariant->price, $order->total_price);
    }
}
