<?php

namespace Tests\Feature\Role;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrieveCreateRolePageTest extends TestCase
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
            ->get(route('roles.create'));

        $response
            ->assertOk()
            ->assertSee('html');
    }
}
