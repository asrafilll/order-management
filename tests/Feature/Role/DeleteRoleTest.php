<?php

namespace Tests\Feature\Role;

use App\Enums\PermissionEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\UserFactory;

class DeleteRoleTest extends TestCase
{
    use RefreshDatabase;
    use UserFactory;

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
            ->delete(route('roles.destroy', [
                'role' => '0',
            ]));

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_should_success_delete_role()
    {
        /** @var Role */
        $role = Role::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->delete(route('roles.destroy', $role));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }

    /**
     * @return void
     */
    public function test_should_error_when_role_used_by_users()
    {
        /** @var User */
        $userForRole = User::factory()->create();
        /** @var Role */
        $role = Role::factory()->create();
        $userForRole->assignRole($role);
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->delete(route('roles.destroy', $role));

        $response->assertForbidden();
    }
}
