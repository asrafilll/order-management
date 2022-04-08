<?php

namespace Tests\Feature\Role;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrieveRolesPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get(route('roles.index'));

        $response
            ->assertOk()
            ->assertSee('html');
    }
}
