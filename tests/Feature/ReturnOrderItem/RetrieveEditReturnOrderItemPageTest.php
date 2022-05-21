<?php

namespace Tests\Feature\ReturnOrderItem;

use App\Enums\PermissionEnum;
use App\Models\ReturnOrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrieveEditReturnOrderItemPageTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        /** @var ReturnOrderItem */
        $returnOrderItem = ReturnOrderItem::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_order_items()
                )
            )
            ->get(route('return-order-items.edit', $returnOrderItem));

        $response->assertOk();
        $this->assertHtmlResponse($response);
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
            ->get(route('return-order-items.edit', ['returnOrderItem' => '0']));

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_should_error_retrieve_when_return_order_item_was_published()
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
            ->get(route('return-order-items.edit', $returnOrderItem));

        $response->assertForbidden();
    }
}
