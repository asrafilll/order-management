<?php

namespace Tests\Feature\Order;

use App\Enums\PermissionEnum;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderSource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_create_order()
    {
        /** @var OrderSource */
        $orderSource = OrderSource::factory()->create();
        /** @var Customer */
        $customer = Customer::factory()->create();

        $input = [
            'source_id' => $orderSource->id,
            'source_name' => $orderSource->name,
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_phone' => $customer->phone,
            'customer_address' => $customer->address,
            'customer_province' => $customer->province,
            'customer_city' => $customer->city,
            'customer_subdistrict' => $customer->subdistrict,
            'customer_village' => $customer->village,
            'customer_postal_code' => $customer->postal_code,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->post(route('orders.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas((new Order())->getTable(), $input);
    }

    /**
     * @dataProvider invalidProvider
     * @param array $input
     * @param array $errors
     * @return void
     */
    public function test_should_error_create_order(
        array $input,
        array $errors
    ) {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->post(route('orders.store'), $input);

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
            'all fields null' => [
                [
                    'source_id' => null,
                    'source_name' => null,
                    'customer_id' => null,
                    'customer_name' => null,
                    'customer_phone' => null,
                    'customer_address' => null,
                    'customer_province' => null,
                    'customer_city' => null,
                    'customer_subdistrict' => null,
                    'customer_village' => null,
                    'customer_postal_code' => null,
                ],
                [
                    'source_id',
                    'source_name',
                    'customer_id',
                    'customer_name',
                    'customer_phone',
                    'customer_address',
                    'customer_province',
                    'customer_city',
                    'customer_subdistrict',
                    'customer_village',
                    'customer_postal_code',
                ]
            ],
            'source_id: (not exists), customer_id: (not exists), customer_phone: (not numeric), customer_postal_code: (not numeric)' => [
                [
                    'source_id' => 1,
                    'source_name' => 'Source #1',
                    'customer_id' => 1,
                    'customer_name' => 'Customer #1',
                    'customer_phone' => 'some-string',
                    'customer_address' => 'Sample address',
                    'customer_province' => 'Sample province',
                    'customer_city' => 'Sample City',
                    'customer_subdistrict' => 'Sample subdistrict',
                    'customer_village' => 'Sample village',
                    'customer_postal_code' => 'some-string',
                ],
                [
                    'source_id',
                    'customer_id',
                    'customer_phone',
                    'customer_postal_code',
                ],
            ],
        ];
    }
}
