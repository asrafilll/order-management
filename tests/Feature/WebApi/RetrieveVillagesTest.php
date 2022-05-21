<?php

namespace Tests\Feature\WebApi;

use Database\Seeders\VillageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrieveVillagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_return_json_response()
    {
        $this->getJson(route('web-api.subdistricts.index'))
            ->assertOk()
            ->assertJsonStructure(['data']);
    }
}
