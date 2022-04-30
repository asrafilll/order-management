<?php

namespace Tests\Feature\Order\Note;

use Tests\TestCase;
use Tests\Utils\UserFactory;
use App\Enums\PermissionEnum;
use App\Enums\OrderStatusEnum;
use Tests\Utils\ResponseAssertion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Utils\OrderFactory;

class UpdateOrderNoteTest extends TestCase
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
            'note' => 'Example note for order',
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.note.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $order->refresh();

        $this->assertEquals('Example note for order', $order->note);
    }

    /**
     * @return void
     */
    public function test_should_error_update_order_items_discount_when_order_is_not_editable()
    {
        $order = $this->createOrder(OrderStatusEnum::processed());
        $input = [
            'note' => 'Example note for order',
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.note.update', $order), $input);

        $response->assertForbidden();
    }
}
