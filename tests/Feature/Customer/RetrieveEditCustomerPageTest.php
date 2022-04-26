<?php

namespace Tests\Feature\Customer;

use App\Enums\PermissionEnum;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrieveEditCustomerPageTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        /** @var Customer */
        $customer = Customer::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_customers()
                )
            )
            ->get(route('customers.edit', $customer));

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
                    PermissionEnum::manage_customers()
                )
            )
            ->get(route('customers.edit', ['customer' => '0']));

        $response->assertNotFound();
    }
}
