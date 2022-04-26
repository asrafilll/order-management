<?php

namespace Tests\Feature\WebApi;

use Database\Seeders\ProvinceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrieveProvincesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ProvinceSeeder::class);
    }

    public function test_should_return_json_response()
    {
        $this->getJson(route('web-api.provinces.index'))
            ->assertOk()
            ->assertJsonStructure(['data']);
    }
}
