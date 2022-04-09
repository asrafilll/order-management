<?php

namespace Tests\Feature\User;

use App\Enums\PermissionEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tests\Utils\UserFactory;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_create_user()
    {
        /** @var Role */
        $role = Role::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->post(route('users.store'), [
                'name' => 'John',
                'email' => 'john@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'role' => $role->id,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $createdUser = User::whereEmail('john@example.com')->first();
        $this->assertEquals('John', $createdUser->name);
        $this->assertEquals('john@example.com', $createdUser->email);
        $this->assertTrue(Hash::check('password', $createdUser->password));
        $this->assertTrue($createdUser->hasRole($role));
    }

    /**
     * @dataProvider invalidProvider
     * @param callable $data
     * @param array $errors
     * @return void
     */
    public function test_should_error_create_user(
        callable $data,
        array $errors
    ) {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->post(route('users.store'), $data());

        $response
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    public function invalidProvider()
    {
        return [
            'name: null, email: null, password: null, password_confirmation: null, role: null' => [
                function () {
                    return [];
                },
                [
                    'name',
                    'email',
                    'password',
                    'role',
                ]
            ],
            'name: John, email: johndoe, password: 1234, password_confirmation: 1234, role: (0)' => [
                function () {
                    return [
                        'name' => 'John',
                        'email' => 'johndoe',
                        'password' => '1234',
                        'password_confirmation' => '1234',
                        'role' => 0,
                    ];
                },
                [
                    'email',
                    'password',
                    'role',
                ],
            ],
            'name: John, email: john@example.com, password: secret, password_confirmation: 1234, role: (based_on_factory)' => [
                function () {
                    return [
                        'name' => 'John',
                        'email' => 'john@example.com',
                        'password' => 'secret',
                        'password_confirmation' => '1234',
                        'role' => Role::factory()->create()->id,
                    ];
                },
                [
                    'password'
                ],
            ],
        ];
    }

    /**
     * @return void
     */
    public function test_should_error_create_user_when_email_already_registered()
    {
        /** @var User */
        $existingUser = User::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->post(route('users.store'), [
                'name' => 'John',
                'email' => $existingUser->email,
                'password' => 'secret',
                'password_confirmation' => 'secret',
                'role' => Role::factory()->create()->id,
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['email']);
    }
}
