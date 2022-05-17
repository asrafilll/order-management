<?php

namespace Tests\Feature\Customer;

use App\Enums\CustomerTypeEnum;
use App\Enums\PermissionEnum;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class UpdateCustomerTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_update_customer()
    {
        /** @var Customer */
        $customer = Customer::factory()->create();
        $input = [
            'name' => 'Updated Customer',
            'phone' => $customer->phone,
            'address' => 'Updated address',
            'province' => 'Updated province',
            'city' => 'Updated city',
            'subdistrict' => 'Updated subdistrict',
            'village' => 'Updated village',
            'postal_code' => '12345',
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_customers()
                )
            )
            ->put(route('customers.update', $customer), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas(
            $customer->getTable(),
            $input + ['type' => $customer->type]
        );
    }

    /**
     * @dataProvider invalidProvider
     * @param array $input
     * @param array $errors
     * @return void
     */
    public function test_should_error_update_customer(
        array $input,
        array $errors
    )
    {
        /** @var Customer */
        $customer = Customer::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_customers()
                )
            )
            ->put(route('customers.update', $customer), $input);

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
                    'name' => null,
                    'phone' => null,
                    'address' => null,
                    'province' => null,
                    'city' => null,
                    'subdistrict' => null,
                    'village' => null,
                    'postal_code' => null,
                ],
                [
                    'name',
                    'phone',
                    'address',
                    'province',
                    'city',
                    'subdistrict',
                    'village',
                ],
            ],
            'phone: (not numeric), postal_code: (not numeric)' => [
                [
                    'name' => 'Customer #1',
                    'phone' => 'some-string',
                    'address' => 'Address customer 1',
                    'province' => 'JAWA BARAT',
                    'city' => 'BANDUNG',
                    'subdistrict' => 'CIBEUNYING KIDUL',
                    'village' => 'CICADAS',
                    'postal_code' => 'some-string',
                ],
                [
                    'phone',
                    'postal_code',
                ],
            ],
        ];
    }

    /**
     * @return void
     */
    public function test_should_error_when_not_found()
    {
        $input = [
            'name' => 'Updated Customer'
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_customers()
                )
            )
            ->put(route('customers.update', ['customer' => 0]), $input);

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_should_error_when_phone_already_used()
    {
        /** @var Customer */
        $customer = Customer::factory()->create();
        /** @var Customer */
        $customerWhichHasUsedPhone = Customer::factory()->create();
        $input = [
            'name' => 'Customer #1',
            'phone' => $customerWhichHasUsedPhone->phone,
            'address' => 'Sample address for customer 1',
            'province' => 'JAWA BARAT',
            'city' => 'BANDUNG',
            'subdistrict' => 'CIBEUNYING KIDUL',
            'village' => 'CICADAS',
            'postal_code' => '40121',
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_customers()
                )
            )
            ->put(route('customers.update', $customer), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['phone']);
    }
}
