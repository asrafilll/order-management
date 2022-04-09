<?php

namespace Tests\Feature\Role;

use App\Enums\PermissionEnum;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrieveEditRolePageTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        /** @var Role */
        $role = Role::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
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
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->get(route('roles.edit', [
                'role' => '0',
            ]));

        $response->assertNotFound();
    }
}
