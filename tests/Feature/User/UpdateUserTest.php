<?php

namespace Tests\Feature\User;

use App\Enums\PermissionEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\UserFactory;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_error_when_user_not_found()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->put(
                route('users.update', ['user' => '0']),
                [
                    'name' => 'John',
                    'email' => 'john@example.com',
                    'role' => Role::factory()->create()->id,
                ]
            );

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_should_success_update_user()
    {
        /** @var User */
        $userForUpdate = User::factory()->create();
        /** @var Role */
        $role = Role::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->put(
                route('users.update', $userForUpdate),
                [
                    'name' => 'John',
                    'email' => 'john@example.com',
                    'role' => $role->id,
                ]
            );

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $userForUpdate->refresh();
        $this->assertEquals('John', $userForUpdate->name);
        $this->assertEquals('john@example.com', $userForUpdate->email);
        $this->assertTrue($userForUpdate->hasRole($role));
    }

    /**
     * @dataProvider invalidProvider
     * @param callable $data
     * @param array $errors
     * @return void
     */
    public function test_should_error_update_user(callable $data, array $errors)
    {
        /** @var User */
        $userForUpdate = User::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->put(route('users.update', $userForUpdate), $data());

        $response
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
    }

    public function invalidProvider()
    {
        return [
            'name: null, email: null, role: null' => [
                fn () => [],
                [
                    'name',
                    'email',
                    'role',
                ],
            ],
            'name: John, email: johndoe, role: (based_on_factory)' => [
                fn () => [
                    'name' => 'John',
                    'email' => 'johndoe',
                    'role' => Role::factory()->create()->id,
                ],
                [
                    'email',
                ],
            ],
        ];
    }

    /**
     * @return void
     */
    public function test_should_error_update_user_when_email_already_used()
    {
        /** @var User */
        $userForUpdate1 = User::factory()->create();
        /** @var User */
        $userForUpdate2 = User::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->put(route('users.update', $userForUpdate2), [
                'name' => 'John',
                'email' => $userForUpdate1->email,
                'role' => Role::factory()->create()->id,
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['email']);
    }
}
