<?php

namespace Tests\Feature\Role;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateRoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_should_success_create_role()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->post(route('roles.store'), [
                'name' => 'Super Admin'
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas((new Role())->getTable(), [
            'name' => 'Super Admin',
        ]);
    }
}
