<?php

namespace Tests\Feature\Customer;

use App\Enums\PermissionEnum;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class DeleteCustomerTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_delete_customer()
    {
        /** @var Customer */
        $customer = Customer::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_customers()
                )
            )
            ->delete(route('customers.destroy', $customer));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }

    public function test_should_error_when_not_found()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_customers()
                )
            )
            ->delete(route('customers.destroy', ['customer' => '0']));

        $response->assertNotFound();
    }
}
