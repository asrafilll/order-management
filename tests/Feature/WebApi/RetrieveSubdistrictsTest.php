<?php

namespace Tests\Feature\WebApi;

use Database\Seeders\SubdistrictSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrieveSubdistrictsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SubdistrictSeeder::class);
    }

    public function test_should_return_json_response()
    {
        $this->getJson(route('web-api.subdistricts.index'))
            ->assertOk()
            ->assertJsonStructure(['data']);
    }
}
