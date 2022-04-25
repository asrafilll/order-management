<?php

namespace Tests\Feature\Product;

use App\Enums\PermissionEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ProductFactory;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrieveEditProductPageTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;
    use ProductFactory;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_products()
                )
            )
            ->get(route('products.edit', $this->createProduct()));

        $response->assertStatus(200);
        $this->assertHtmlResponse($response);
        $response->assertViewHas('product');
    }
}
