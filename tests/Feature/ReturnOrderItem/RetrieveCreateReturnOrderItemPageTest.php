<?php

namespace Tests\Feature\ReturnOrderItem;

use App\Enums\PermissionEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrieveCreateReturnOrderItemPageTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_return_order_items()
                )
            )
            ->get(route('return-order-items.create'));

        $response->assertOk();
        $this->assertHtmlResponse($response);
    }
}