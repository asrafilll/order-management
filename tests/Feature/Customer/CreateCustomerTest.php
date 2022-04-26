<?php

namespace Tests\Feature\Customer;

use App\Enums\CustomerTypeEnum;
use App\Enums\PermissionEnum;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class CreateCustomerTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_create_customer()
    {
        $input = [
            'name' => 'Customer #1',
            'phone' => '081123123123',
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
            ->post(route('customers.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas(
            (new Customer())->getTable(),
            $input + ['type' => CustomerTypeEnum::new()->value]
        );
    }

    /**
     * @dataProvider invalidProvider
     * @param array $input
     * @param array $errors
     * @return void
     */
    public function test_should_error_create_customer(
        array $input,
        array $errors
    )
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_customers()
                )
            )
            ->post(route('customers.store'), $input);

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
                    'postal_code',
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
    public function test_should_error_when_phone_already_used()
    {
        /** @var Customer */
        $customer = Customer::factory()->create();
        $input = [
            'name' => 'Customer #1',
            'phone' => $customer->phone,
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
            ->post(route('customers.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['phone']);
    }
}
