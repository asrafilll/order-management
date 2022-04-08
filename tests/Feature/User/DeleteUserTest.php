<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteUserTest extends TestCase
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
            ->delete(route('users.destroy', ['user' => '0']));

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_should_error_when_delete_it_self()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();
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
        /** @var Authenticatable */
        $user = User::factory()->create();
        /** @var User */
        $userForDelete = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->delete(route('users.destroy', $userForDelete));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }
}
