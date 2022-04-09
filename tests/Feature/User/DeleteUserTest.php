<?php

namespace Tests\Feature\User;

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\UserFactory;

class DeleteUserTest extends TestCase
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
            ->delete(route('users.destroy', ['user' => '0']));

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_should_error_when_delete_it_self()
    {
        $user = $this->createUserWithPermission(
            PermissionEnum::manage_users_and_roles()
        );
        $response = $this
            ->actingAs($user)
            ->delete(route('users.destroy', $user));

        $response->assertForbidden();
    }

    /**
     * @return void
     */
    public function test_should_success_delete_user()
    {
        /** @var User */
        $userForDelete = User::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->delete(route('users.destroy', $userForDelete));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }
}
