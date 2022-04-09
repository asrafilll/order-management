<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;

class RetrieveCreateUserPage extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        /** @var User */
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get(route('users.create'));

        $response->assertStatus(200);
        $this->assertHtmlResponse($response);
        $response->assertViewHas('roles');
    }
}
