<?php

namespace Tests\Feature\OrderSource;

use App\Enums\PermissionEnum;
use App\Models\OrderSource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class DeleteOrderSourceTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_delete_shipping()
    {
        /** @var OrderSource */
        $orderSource = OrderSource::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_order_sources()
                )
            )
            ->delete(route('order-sources.destroy', $orderSource));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }

    public function test_should_error_when_not_found()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_order_sources()
                )
            )
            ->delete(route('order-sources.destroy', ['orderSource' => '0']));

        $response->assertNotFound();
    }
}
