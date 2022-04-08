<?php

namespace Tests\Feature\Role;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class UpdateRoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_should_success_update_role()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();
        /** @var Role */
        $role = Role::factory()->create();
        $response = $this
            ->actingAs($user)
            ->put(route('roles.update', $role), [
                'name' => 'New Role',
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $role->refresh();
        $this->assertEquals('New Role', $role->name);
    }

    /**
     * @return void
     */
    public function test_should_success_update_role_with_permissions()
    {
        $this->seed(PermissionSeeder::class);
        /** @var Authenticatable */
        $user = User::factory()->create();
        /** @var Role */
        $role = Role::factory()->create();
        /** @var Collection */
        $permissions = Permission::query()
            ->take(4)
            ->get();
        $response = $this
            ->actingAs($user)
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
        $this->assertEquals(4, $role->permissions->count());
    }

    /**
     * @dataProvider invalidProvider
     * @param array $data
     * @param array $errors
     * @return void
     */
    public function test_should_error_update_role(array $data, array $errors)
    {
        /** @var Authenticatable */
        $user = User::factory()->create();
        /** @var Role */
        $role = Role::factory()->create();
        $response = $this
            ->actingAs($user)
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
        /** @var Authenticatable */
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get(route('roles.update', [
                'role' => '0',
            ]));

        $response->assertNotFound();
    }
}
