<?php

namespace Tests\Feature\WebApi;

use Database\Seeders\CitySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrieveCitiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_return_json_response()
    {
        $this->getJson(route('web-api.cities.index'))
            ->assertOk()
            ->assertJsonStructure(['data']);
    }
}
