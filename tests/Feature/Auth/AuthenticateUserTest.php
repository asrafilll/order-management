<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_should_authenticate_with_redirect_response()
    {
        /** @var User */
        $user = User::factory()->create();
        $response = $this->post(
            route('auth.login.store'),
            [
                'email' => $user->email,
                'password' => UserFactory::DEFAULT_PASSWORD,
            ]
        );

        $this->isAuthenticated();
        $response->assertRedirect();
    }

    /**
     * @return void
     */
    public function test_should_can_not_authenticate_with_invalid_credential()
    {
        /** @var User */
        $user = User::factory()->create();
        $response = $this->post(
            route('auth.login.store'),
            [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]
        );
        $this->assertGuest();
        $response->assertSessionHasErrors([
            'email',
        ]);
    }
}
