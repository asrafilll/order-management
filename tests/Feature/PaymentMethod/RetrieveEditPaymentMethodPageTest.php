<?php

namespace Tests\Feature\PaymentMethod;

use App\Enums\PermissionEnum;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrieveEditPaymentMethodPageTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        /** @var PaymentMethod */
        $paymentMethod = PaymentMethod::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_payment_methods()
                )
            )
            ->get(route('payment-methods.edit', $paymentMethod));

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
                    PermissionEnum::manage_payment_methods()
                )
            )
            ->get(route('payment-methods.edit', ['paymentMethod' => '0']));

        $response->assertNotFound();
    }
}
