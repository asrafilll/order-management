<?php

namespace Tests\Feature\User;

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrieveEditUserPageTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        /** @var User */
        $userForEdit = User::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->get(route('users.edit', $userForEdit));

        $response->assertOk();
        $this->assertHtmlResponse($response);
        $response->assertViewHas('roles');
    }
}
