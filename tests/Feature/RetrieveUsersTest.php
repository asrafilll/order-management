<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetrieveUsersTest extends TestCase
{
    use RefreshDatabase;

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
        $response = $this->getJson(route('users.index'));

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
        $response = $this->get(route('users.index'));

        $response
            ->assertStatus(200)
            ->assertSee('html');
    }
}
