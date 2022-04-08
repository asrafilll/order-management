<?php

namespace Tests\Feature\Role;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            'name: null' => [
                [
                    'name' => null
                ],
                [
                    'name',
                ]
            ]
        ];
    }
}
