<?php

namespace Tests\Feature\WebApi;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\UserFactory;

class RetrieveDayReturnOrdersTest extends TestCase
{
    use RefreshDatabase;
    use UserFactory;

    public function test_should_return_json_response()
    {
        $response = $this
            ->actingAs(
                $this->createUser()
            )
            ->getJson(route('web-api.days.return-orders.index'));

        $response
            ->assertOk()
            ->assertJsonStructure(['data']);
    }
}
