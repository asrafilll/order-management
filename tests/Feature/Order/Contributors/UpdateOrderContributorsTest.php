<?php

namespace Tests\Feature\Order\Contributors;

use App\Enums\OrderStatusEnum;
use Tests\TestCase;
use Tests\Utils\UserFactory;
use App\Enums\PermissionEnum;
use App\Models\Employee;
use Tests\Utils\ResponseAssertion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Utils\OrderBuilder;

class UpdateOrderContributorsTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_update_order_contributors()
    {
        $order = (new OrderBuilder)->addItems()->build();
        /** @var Employee */
        $employee = Employee::factory()->create();
        $input = [
            'sales_id' => $employee->id,
            'sales_name' => $employee->name,
            'creator_id' => $employee->id,
            'creator_name' => $employee->name,
            'packer_id' => $employee->id,
            'packer_name' => $employee->name,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.contributors.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $order->refresh();

        $this->assertEquals($employee->id, $order->sales_id);
        $this->assertEquals($employee->name, $order->sales_name);
        $this->assertEquals($employee->id, $order->creator_id);
        $this->assertEquals($employee->name, $order->creator_name);
        $this->assertEquals($employee->id, $order->packer_id);
        $this->assertEquals($employee->name, $order->packer_name);
    }

    /**
     * @return void
     */
    public function test_should_error_update_order_contributors_when_order_is_not_editable()
    {
        $order = (new OrderBuilder)->setStatus(OrderStatusEnum::processed())->addItems()->build();
        /** @var Employee */
        $employee = Employee::factory()->create();
        $input = [
            'sales_id' => $employee->id,
            'sales_name' => $employee->name,
            'creator_id' => $employee->id,
            'creator_name' => $employee->name,
            'packer_id' => $employee->id,
            'packer_name' => $employee->name,
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.contributors.update', $order), $input);

        $response->assertForbidden();
    }

    /**
     * @dataProvider invalidProvider
     * @param array $input
     * @param array $errors
     * @return void
     */
    public function test_should_error_update_order_contributors_when_request_data_is_invalid(
        array $input,
        array $errors
    ) {
        $order = (new OrderBuilder)->addItems()->build();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->put(route('orders.contributors.update', $order), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
    }

    /**
     * @return array
     */
    public function invalidProvider()
    {
        return [
            'all fields: null' => [
                [
                    'sales_id' => null,
                    'sales_name' => null,
                    'creator_id' => null,
                    'creator_name' => null,
                    'packer_id' => null,
                    'packer_name' => null,
                ],
                [
                    'sales_id',
                    'sales_name',
                    'creator_id',
                    'creator_name',
                    'packer_id',
                    'packer_name',
                ],
            ],
            'sales_id: (not exists), creator_id: (not exists), packer_id: (not exists)' => [
                [
                    'sales_id' => 0,
                    'sales_name' => 'Employee #1',
                    'creator_id' => 0,
                    'creator_name' => 'Employee #1',
                    'packer_id' => 0,
                    'packer_name' => 'Employee #1',
                ],
                [
                    'sales_id',
                    'creator_id',
                    'packer_id',
                ],
            ],
        ];
    }
}
