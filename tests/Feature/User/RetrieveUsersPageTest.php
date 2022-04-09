<?php

namespace Tests\Feature\User;

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\UserFactory;
use Tests\Utils\ResponseAssertion;

class RetrieveUsersPageTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory(10)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_return_json_users()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->getJson(route('users.index'));

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'email_verified_at',
                        'created_at',
                        'updated_at'
                    ]
                ],
                'meta'
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_return_view_users()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_users_and_roles()
                )
            )
            ->get(route('users.index'));

        $response->assertStatus(200);
        $this->assertHtmlResponse($response);
    }
}
