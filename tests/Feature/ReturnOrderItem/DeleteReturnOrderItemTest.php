<?php

namespace Tests\Feature\ReturnOrderItem;

use App\Enums\PermissionEnum;
use App\Models\ReturnOrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class DeleteReturnOrderItemTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_delete_return_order_item()
    {
        /** @var ReturnOrderItem */
        $returnOrderItem = ReturnOrderItem::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_order_items()
                )
            )
            ->delete(route('return-order-items.destroy', $returnOrderItem));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertEquals(0, ReturnOrderItem::count());
    }

    /**
     * @return void
     */
    public function test_should_error_when_not_found()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_order_items()
                )
            )
            ->delete(route('return-order-items.destroy', ['returnOrderItem' => '0']));

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_should_error_delete_when_return_order_item_was_published()
    {
        /** @var ReturnOrderItem */
        $returnOrderItem = ReturnOrderItem::factory()
            ->published()
            ->create();

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_order_items()
                )
            )
            ->delete(route('return-order-items.destroy', $returnOrderItem));

        $response->assertForbidden();
    }
}
