<?php

namespace Tests\Feature\Order\ClosingDate;

use App\Enums\OrderStatusEnum;
use App\Enums\PermissionEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Tests\Utils\OrderBuilder;
use Tests\Utils\UserFactory;

class UpdateTest extends TestCase
{
    use RefreshDatabase;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_update_data()
    {
        $order = (new OrderBuilder)->build();
        $date = Carbon::now()->format('Y-m-d');
        $input = [
            'closing_date' => $date,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.closing-date.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $order->refresh();
        $this->assertEquals($date, $order->closing_date);
    }
}
