<?php

namespace Tests\Feature\PaymentMethod;

use App\Enums\PermissionEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrievePaymentMethodsPageTest extends TestCase
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
                    PermissionEnum::manage_payment_methods()
                )
            )
            ->get(route('payment-methods.index'));

        $response->assertOk();
        $this->assertHtmlResponse($response);
    }
}
