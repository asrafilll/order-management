<?php

namespace Tests\Feature\PaymentMethod;

use App\Enums\PermissionEnum;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class DeletePaymentMethodTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_delete_shipping()
    {
        /** @var PaymentMethod */
        $paymentMethod = PaymentMethod::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_payment_methods()
                )
            )
            ->delete(route('payment-methods.destroy', $paymentMethod));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }

    public function test_should_error_when_not_found()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_payment_methods()
                )
            )
            ->delete(route('payment-methods.destroy', ['paymentMethod' => '0']));

        $response->assertNotFound();
    }
}
