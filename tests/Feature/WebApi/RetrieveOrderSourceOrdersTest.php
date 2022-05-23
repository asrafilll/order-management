<?php

namespace Tests\Feature\WebApi;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\UserFactory;

class RetrieveOrderSourceOrdersTest extends TestCase
{
    use RefreshDatabase;
    use UserFactory;

    public function test_should_return_json_response()
    {
        $this
            ->actingAs(
                $this->createUser()
            )
            ->getJson(route('web-api.order-sources.orders.index'))
            ->assertOk()
            ->assertJsonStructure(['data']);
    }
}
