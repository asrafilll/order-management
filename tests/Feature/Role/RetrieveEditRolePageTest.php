<?php

namespace Tests\Feature\Role;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;

class RetrieveEditRolePageTest extends TestCase
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
        /** @var Role */
        $role = Role::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get(route('roles.edit', $role));

        $response->assertOk();
        $this->assertHtmlResponse($response);
        $response->assertViewHas('role');
        $response->assertViewHas('permissions');
    }

    /**
     * @return void
     */
    public function test_should_error_when_not_found()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get(route('roles.edit', [
                'role' => '0',
            ]));

        $response->assertNotFound();
    }
}
