<?php

namespace Tests\Feature\PaymentMethod;

use App\Enums\PermissionEnum;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class UpdatePaymentMethodTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_update_shipping()
    {
        /** @var PaymentMethod */
        $paymentMethod = PaymentMethod::factory()->create();
        $input = [
            'name' => 'Updated PaymentMethod'
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_payment_methods()
                )
            )
            ->put(route('payment-methods.update', $paymentMethod), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas($paymentMethod->getTable(), $input);
    }

    /**
     * @return void
     */
    public function test_should_error_update_shipping()
    {
        /** @var PaymentMethod */
        $paymentMethod = PaymentMethod::factory()->create();
        $input = [
            'name' => null
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_payment_methods()
                )
            )
            ->put(route('payment-methods.update', $paymentMethod), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['name']);
    }

    /**
     * @return void
     */
    public function test_should_error_when_not_found()
    {
        $input = [
            'name' => 'Updated PaymentMethod'
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_payment_methods()
                )
            )
            ->put(route('payment-methods.update', ['paymentMethod' => 0]), $input);

        $response->assertNotFound();
    }
}
