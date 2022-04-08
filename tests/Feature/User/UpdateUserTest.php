<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_should_error_when_user_not_found()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->put(
                route('users.update', ['user' => '0']),
                [
                    'name' => 'John',
                    'email' => 'john@example.com',
                ]
            );

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_should_success_update_user()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();
        /** @var User */
        $userForUpdate = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->put(
                route('users.update', $userForUpdate),
                [
                    'name' => 'John',
                    'email' => 'john@example.com',
                ]
            );

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $userForUpdate->refresh();
        $this->assertEquals('John', $userForUpdate->name);
        $this->assertEquals('john@example.com', $userForUpdate->email);
    }

    /**
     * @dataProvider invalidProvider
     * @param array $data
     * @param array $errors
     * @return void
     */
    public function test_should_error_update_user(array $data, array $errors)
    {
        /** @var Authenticatable */
        $user = User::factory()->create();
        /** @var User */
        $userForUpdate = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->put(route('users.update', $userForUpdate), $data);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
    }

    public function invalidProvider()
    {
        return [
            'name: null, email: null' => [
                [
                    'name' => null,
                    'email' => null,
                ],
                [
                    'name',
                    'email',
                ],
            ],
            'name: John, email: johndoe' => [
                [
                    'name' => 'John',
                    'email' => 'johndoe',
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
        /** @var Authenticatable */
        $user = User::factory()->create();
        /** @var User */
        $userForUpdate1 = User::factory()->create();
        /** @var User */
        $userForUpdate2 = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->put(route('users.update', $userForUpdate2), [
                'name' => 'John',
                'email' => $userForUpdate1->email,
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['email']);
    }
}
