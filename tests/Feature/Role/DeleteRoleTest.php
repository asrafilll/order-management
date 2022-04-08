<?php

namespace Tests\Feature\Role;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteRoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_should_error_when_not_found()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->delete(route('roles.destroy', [
                'role' => '0',
            ]));

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_should_success_delete_role()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();
        /** @var Role */
        $role = Role::factory()->create();
        $response = $this
            ->actingAs($user)
            ->delete(route('roles.destroy', $role));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }
}
