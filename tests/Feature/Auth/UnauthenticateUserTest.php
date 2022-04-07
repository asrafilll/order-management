<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnauthenticateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_should_unauthenticate_with_redirect_response()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('auth.login.destroy'));

        $this->assertFalse($this->isAuthenticated());
        $response->assertRedirect();
    }
}
