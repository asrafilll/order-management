<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrieveEditUserPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();
        /** @var User */
        $userForEdit = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get(route('users.edit', $userForEdit));

        $response
            ->assertOk()
            ->assertSee('html');
    }
}
