<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrieveLoginPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_should_return_html()
    {
        $response = $this->get(route('auth.login.index'));

        $response
            ->assertStatus(200)
            ->assertSee('html');
    }

    /**
     * @return void
     */
    public function test_should_redirect_when_authenticated()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('auth.login.index'));

        $response->assertRedirect();
    }
}
