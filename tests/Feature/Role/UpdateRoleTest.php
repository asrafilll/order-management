<?php

namespace Tests\Feature\Role;

use App\Enums\PermissionEnum;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Tests\Utils\UserFactory;

class UpdateRoleTest extends TestCase
{
    use RefreshDatabase;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_update_role()
    {
        /** @var Role */
        $role = Role::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->put(route('roles.update', $role), [
                'name' => $role->name,
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $role->refresh();
        $this->assertEquals($role->name, $role->name);
    }

    /**
     * @return void
     */
    public function test_should_success_update_role_with_permissions()
    {
        /** @var Role */
        $role = Role::factory()->create();
        /** @var Collection */
        $permissions = Permission::query()
            ->take(4)
            ->get();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->put(route('roles.update', $role), [
                'name' => 'New Role',
                'permissions' => $permissions
                    ->pluck('id')
                    ->toArray(),
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $role->refresh();
        $this->assertEquals('New Role', $role->name);
        $this->assertEquals($permissions->count(), $role->permissions->count());
    }

    /**
     * @dataProvider invalidProvider
     * @param array $data
     * @param array $errors
     * @return void
     */
    public function test_should_error_update_role(array $data, array $errors)
    {
        /** @var Role */
        $role = Role::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->put(route('roles.update', $role), $data);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
    }

    public function invalidProvider()
    {
        return [
            [
                [],
                [
                    'name',
                ],
            ],
            'name: null' => [
                [
                    'name' => null
                ],
                [
                    'name',
                ]
            ],
            'name: Super Admin, permissions: example' => [
                [
                    'name' => 'Super Admin',
                    'permissions' => 'example'
                ],
                [
                    'permissions',
                ],
            ],
            'name: Super Admin, permissions: [99]' => [
                [
                    'name' => 'Super Admin',
                    'permissions' => [
                        99,
                    ],
                ],
                [
                    'permissions.0',
                ],
            ]
        ];
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
            ->put(route('roles.update', [
                'role' => '0',
            ]), [
                'name' => 'New Role',
            ]);

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_should_error_when_name_already_exists()
    {
        /** @var Role */
        $existingRole = Role::factory()->create();
        /** @var Role */
        $roleForUpdate = Role::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->put(route('roles.update', $roleForUpdate), [
                'name' => $existingRole->name
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['name']);
    }
}
