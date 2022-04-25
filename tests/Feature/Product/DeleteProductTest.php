<?php

namespace Tests\Feature\Product;

use App\Enums\PermissionEnum;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\ProductFactory;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;
    use ProductFactory;

    /**
     * @return void
     */
    public function test_should_error_when_product_not_found()
    {
        $response = $this
            ->actingAs(
                $this->createUser()
            )
            ->delete(route('products.destroy', ['product' => 0]));

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_should_success_delete_product()
    {
        /** @var Product */
        $product = $this->createProduct();

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_products()
                )
            )
            ->delete(route('products.destroy', $product));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $product->variants->each(function (ProductVariant $productVariant) {
            $this->assertDatabaseMissing($productVariant->getTable(), [
                'id' => $productVariant->id,
            ]);
        });

        $product->options->each(function (ProductOption $productOption) {
            $this->assertDatabaseMissing($productOption->getTable(), [
                'id' => $productOption->id,
            ]);
        });

        $this->assertDatabaseMissing($product->getTable(), [
            'id' => $product->id,
        ]);
    }
}
