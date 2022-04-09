<?php

namespace Tests\Feature\User;

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tests\Utils\UserFactory;

class UpdateUserPasswordTest extends TestCase
{
    use RefreshDatabase;
    use UserFactory;

    /**
     * @dataProvider invalidProvider
     * @param array $data
     * @param array $errors
     * @return void
     */
    public function test_should_error_update_user_password(array $data, array $errors)
    {
        /** @var User */
        $userForUpdate = User::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->put(route('users.update.password', $userForUpdate), $data);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
    }

    public function invalidProvider()
    {
        return [
            'password: null, password_confirmation: null' => [
                [
                    'password' => null,
                    'password_confirmation' => null,
                ],
                [
                    'password',
                ],
            ],
            'password: 123123, password_confirmation: 1231234' => [
                [
                    'password' => '123123',
                    'password_confirmation' => '1231234',
                ],
                [
                    'password',
                ],
            ],
        ];
    }

    /**
     * @return void
     */
    public function test_should_success_update_user_password()
    {
        /** @var User */
        $userForUpdate = User::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->put(route('users.update.password', $userForUpdate), [
                'password' => '123123',
                'password_confirmation' => '123123',
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $userForUpdate->refresh();
        $this->assertTrue(Hash::check('123123', $userForUpdate->password));
    }
}
