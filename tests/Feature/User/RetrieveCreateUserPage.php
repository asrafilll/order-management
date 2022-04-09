<?php

namespace Tests\Feature\User;

use App\Enums\PermissionEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrieveCreateUserPage extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->get(route('users.create'));

        $response->assertStatus(200);
        $this->assertHtmlResponse($response);
        $response->assertViewHas('roles');
    }
}
