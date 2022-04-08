<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_should_success_create_user()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->post(route('users.store'), [
                'name' => 'John',
                'email' => 'john@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $createdUser = User::whereEmail('john@example.com')->first();
        $this->assertEquals('John', $createdUser->name);
        $this->assertEquals('john@example.com', $createdUser->email);
        $this->assertTrue(Hash::check('password', $createdUser->password));
    }

    /**
     * @dataProvider invalidProvider
     * @param array $data
     * @param array $errors
     * @return void
     */
    public function test_should_error_create_user(
        array $data,
        array $errors
    ) {
        /** @var Authenticatable */
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->post(route('users.store'), $data);

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
            'name: null, email: null, password: null, password_confirmation: null' => [
                [],
                [
                    'name',
                    'email',
                    'password',
                ]
            ],
            'name: John, email: johndoe, password: 1234, password_confirmation: 1234' => [
                [
                    'John',
                    'johndoe',
                    '1234',
                    '1234',
                ],
                [
                    'email',
                    'password',
                ],
            ],
            'name: John, email: john@example.com, password: secret, password_confirmation: 1234' => [
                [
                    'John',
                    'john@example.com',
                    'secret',
                    '1234'
                ],
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
        /** @var Authenticatable */
        $user = User::factory()->create();
        /** @var User */
        $existingUser = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->post(route('users.store'), [
                'name' => 'John',
                'email' => $existingUser->email,
                'password' => 'secret',
                'password_confirmation' => 'secret',
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['email']);
    }
}
