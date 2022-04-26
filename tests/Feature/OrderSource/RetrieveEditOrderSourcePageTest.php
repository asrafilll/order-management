<?php

namespace Tests\Feature\OrderSource;

use App\Enums\PermissionEnum;
use App\Models\OrderSource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrieveEditOrderSourcePageTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        /** @var OrderSource */
        $orderSource = OrderSource::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_order_sources()
                )
            )
            ->get(route('order-sources.edit', $orderSource));

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
                    PermissionEnum::manage_order_sources()
                )
            )
            ->get(route('order-sources.edit', ['orderSource' => '0']));

        $response->assertNotFound();
    }
}
