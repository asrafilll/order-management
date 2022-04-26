<?php

namespace Tests\Feature\PaymentMethod;

use App\Enums\PermissionEnum;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class CreatePaymentMethodTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_create_shipping()
    {
        $input = [
            'name' => 'Payment Method #1',
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_payment_methods()
                )
            )
            ->post(route('payment-methods.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas((new PaymentMethod())->getTable(), $input);
    }

    /**
     * @return void
     */
    public function test_should_error_create_shipping()
    {
        $input = [
            'name' => null,
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_payment_methods()
                )
            )
            ->post(route('payment-methods.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['name']);
    }
}
