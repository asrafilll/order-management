<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;

class RetrieveEditUserPageTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();
        /** @var User */
        $userForEdit = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get(route('users.edit', $userForEdit));

        $response->assertOk();
        $this->assertHtmlResponse($response);
    }
}
