<?php

namespace Tests\Feature\Order\Note;

use Tests\TestCase;
use Tests\Utils\UserFactory;
use App\Enums\PermissionEnum;
use App\Enums\OrderStatusEnum;
use Tests\Utils\ResponseAssertion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Utils\OrderBuilder;

class UpdateOrderNoteTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_update_order_note()
    {
        $order = (new OrderBuilder)->addItems()->build();
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
}
