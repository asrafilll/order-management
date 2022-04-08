<?php

namespace Tests\Feature\Role;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;

class RetrieveCreateRolePageTest extends TestCase
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
        $response = $this
            ->actingAs($user)
            ->get(route('roles.create'));

        $response->assertOk();
        $this->assertHtmlResponse($response);
        $response->assertViewHas('permissions');
    }
}
