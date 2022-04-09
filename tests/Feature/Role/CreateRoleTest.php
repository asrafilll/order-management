<?php

namespace Tests\Feature\Role;

use App\Enums\PermissionEnum;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Tests\Utils\UserFactory;

class CreateRoleTest extends TestCase
{
    use RefreshDatabase;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_create_role()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->post(route('roles.store'), [
                'name' => 'Super Admin',
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas((new Role())->getTable(), [
            'name' => 'Super Admin',
        ]);
    }

    public function test_should_success_create_role_with_permissions()
    {
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
            ->post(route('roles.store'), [
                'name' => 'Super Admin',
                'permissions' => $permissions
                    ->pluck('id')
                    ->toArray(),
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        /** @var Role */
        $role = Role::first();
        $this->assertEquals('Super Admin', $role->name);
        $this->assertEquals($permissions->count(), $role->permissions()->count());
    }

    /**
     * @dataProvider invalidProvider
     * @param array $data
     * @param array $errors
     * @return void
     */
    public function test_should_error_create_role(array $data, array $errors)
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->post(route('roles.store'), $data);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
    }

    /**
     * @return array
     */
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
                    'name' => null,
                ],
                [
                    'name',
                ],
            ],
            'name: Super Admin, permissions: 1' => [
                [
                    'name' => 'Super Admin',
                    'permissions' => 1,
                ],
                [
                    'permissions',
                ],
            ],
            'name: Super Admin, permissions: [0]' => [
                [
                    'name' => 'Super Admin',
                    'permissions' => [
                        0,
                    ],
                ],
                [
                    'permissions.0',
                ],
            ],
            'name: Super Admin, permissions: [example]' => [
                [
                    'name' => 'Super Admin',
                    'permissions' => [
                        'example',
                    ],
                ],
                [
                    'permissions.0',
                ],
            ],
        ];
    }

    /**
     * @return void
     */
    public function test_should_error_create_role_when_name_exists()
    {
        /** @var Role */
        $role = Role::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->post(route('roles.store'), [
                'name' => $role->name,
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['name']);
    }
}
