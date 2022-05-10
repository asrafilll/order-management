<?php

namespace Tests\Feature\OrderSource;

use App\Enums\PermissionEnum;
use App\Models\OrderSource;
use Closure;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class CreateOrderSourceTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @dataProvider validProvider
     * @param string $name
     * @param mixed $parent_id
     * @return void
     */
    public function test_should_success_create_order_source(
        string $name,
        $parent_id
    ) {
        $input = [
            'name' => $name,
            'parent_id' => $parent_id instanceof Closure ? $parent_id() : $parent_id,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_order_sources()
                )
            )
            ->post(route('order-sources.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas((new OrderSource())->getTable(), $input);
    }

    /**
     * @return array
     */
    public function validProvider()
    {
        return [
            'all fields filled' => [
                'name' => 'New Source',
                'parent_id' => function () {
                    return OrderSource::factory()->create()->id;
                },
            ],
            'parent_id: null' => [
                'name' => 'New Source',
                'parent_id' => null,
            ],
        ];
    }

    /**
     * @return void
     */
    public function test_should_error_create_order_source()
    {
        $input = [
            'name' => null,
            'parent_id' => 1,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_order_sources()
                )
            )
            ->post(route('order-sources.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['name', 'parent_id']);
    }
}
