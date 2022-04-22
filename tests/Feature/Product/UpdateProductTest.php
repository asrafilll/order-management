<?php

namespace Tests\Feature\Product;

use App\Enums\ProductStatusEnum;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\Utils\ProductFactory;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;
    use ProductFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createProductViaHttp();
    }


    /**
     * @return void
     */
    public function test_should_success_update_product()
    {
        /** @var Product */
        $product = Product::with(['options', 'variants'])
            ->latest()
            ->first();

        $variants = $product
            ->variants
            ->reduce(function (array $acc, ProductVariant $variant) {
                if ($variant->value1 === 'Green' || $variant->value2 === 'Medium') {
                    return $acc;
                }
                $value1 = Str::substr($variant->value1, 0, 1);
                $value2 = Str::substr($variant->value2, 0, 1);

                $acc[] = [
                    'id' => $variant->id,
                    'name' => implode(' / ', [$value1, $value2]),
                    'price' => 12345,
                    'weight' => 123,
                    'option1' => 'Option 1',
                    'value1' => $value1,
                    'option2' => 'Option 2',
                    'value2' => $value2,
                ];

                return $acc;
            }, []);

        $variants[] = [
            'id' => null,
            'name' => 'R / E',
            'price' => 12345,
            'weight' => 123,
            'option1' => 'Option 1',
            'value1' => 'R',
            'option2' => 'Option 2',
            'value2' => 'E',
        ];

        $variants[] = [
            'id' => null,
            'name' => 'B / E',
            'price' => 12345,
            'weight' => 123,
            'option1' => 'Option 1',
            'value1' => 'B',
            'option2' => 'Option 2',
            'value2' => 'E',
        ];

        $variants[] = [
            'id' => null,
            'name' => 'Y / S',
            'price' => 12345,
            'weight' => 123,
            'option1' => 'Option 1',
            'value1' => 'Y',
            'option2' => 'Option 2',
            'value2' => 'S',
        ];

        $variants[] = [
            'id' => null,
            'name' => 'Y / L',
            'price' => 12345,
            'weight' => 123,
            'option1' => 'Option 1',
            'value1' => 'Y',
            'option2' => 'Option 2',
            'value2' => 'L',
        ];

        $variants[] = [
            'id' => null,
            'name' => 'Y / E',
            'price' => 12345,
            'weight' => 123,
            'option1' => 'Option 1',
            'value1' => 'Y',
            'option2' => 'Option 2',
            'value2' => 'E',
        ];

        $input = [
            'name' => 'Updated Sample Product #1',
            'description' => 'This is updated sample product 1 description',
            'options' => [
                [
                    'name' => 'Option 1',
                    'values' => [
                        'R',
                        'B',
                        'Y',
                        null,
                    ],
                ],
                [
                    'name' => 'Option 2',
                    'values' => [
                        'S',
                        'L',
                        'E',
                        null,
                    ],
                ],
            ],
            'variants' => $variants,
            'status' => ProductStatusEnum::draft()->value,
        ];

        $response = $this
            ->actingAs($this->createUser())
            ->put(route('products.update', $product), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $product->refresh();

        /** @var ProductOption */
        $option1 = $product->options->first();
        /** @var ProductOption */
        $option2 = $product
            ->options
            ->where('id', '!=', $option1->id)
            ->first();

        $this->assertEquals('Updated Sample Product #1', $product->name);
        $this->assertEquals('This is updated sample product 1 description', $product->description);
        $this->assertEquals(ProductStatusEnum::draft()->value, $product->status);
        $this->assertEquals('Option 1', $option1->name);
        $this->assertEquals('["R","B","Y"]', $option1->values);
        $this->assertEquals('Option 2', $option2->name);
        $this->assertEquals('["S","L","E"]', $option2->values);
        $this->assertEquals(count($input['variants']), $product->variants->count());

        Collection::make($variants)
            ->each(function (array $variant) use ($product) {
                $productVariant = $product
                    ->variants
                    ->when(!is_null($variant['id']), function ($variants) use ($variant) {
                        return $variants->where('id', $variant['id']);
                    })
                    ->where('name', $variant['name'])
                    ->where('price', $variant['price'])
                    ->where('weight', $variant['weight'])
                    ->where('option1', $variant['option1'])
                    ->where('value1', $variant['value1'])
                    ->where('option2', $variant['option2'])
                    ->where('value2', $variant['value2'])
                    ->first();

                $this->assertNotNull($productVariant);
            });
    }

    public function createProductViaHttp()
    {
        $input = [
            'name' => 'Sample Product #1',
            'description' => 'This is sample product 1 description',
            'options' => [
                [
                    'name' => 'Color',
                    'values' => [
                        'Red',
                        'Green',
                        'Blue',
                    ],
                ],
                [
                    'name' => 'Size',
                    'values' => [
                        'Small',
                        'Medium',
                        'Large',
                    ],
                ],
            ],
            'variants' => [
                [
                    'name' => 'Red / Small',
                    'price' => 1000,
                    'weight' => 100,
                    'option1' => 'Color',
                    'value1' => 'Red',
                    'option2' => 'Size',
                    'value2' => 'Small',
                ],
                [
                    'name' => 'Red / Medium',
                    'price' => 1000,
                    'weight' => 100,
                    'option1' => 'Color',
                    'value1' => 'Red',
                    'option2' => 'Size',
                    'value2' => 'Medium',
                ],
                [
                    'name' => 'Red / Large',
                    'price' => 1000,
                    'weight' => 100,
                    'option1' => 'Color',
                    'value1' => 'Red',
                    'option2' => 'Size',
                    'value2' => 'Large',
                ],
                [
                    'name' => 'Green / Small',
                    'price' => 1000,
                    'weight' => 100,
                    'option1' => 'Color',
                    'value1' => 'Green',
                    'option2' => 'Size',
                    'value2' => 'Small',
                ],
                [
                    'name' => 'Green / Medium',
                    'price' => 1000,
                    'weight' => 100,
                    'option1' => 'Color',
                    'value1' => 'Green',
                    'option2' => 'Size',
                    'value2' => 'Medium',
                ],
                [
                    'name' => 'Green / Large',
                    'price' => 1000,
                    'weight' => 100,
                    'option1' => 'Color',
                    'value1' => 'Green',
                    'option2' => 'Size',
                    'value2' => 'Large',
                ],
                [
                    'name' => 'Blue / Small',
                    'price' => 1000,
                    'weight' => 100,
                    'option1' => 'Color',
                    'value1' => 'Blue',
                    'option2' => 'Size',
                    'value2' => 'Small',
                ],
                [
                    'name' => 'Blue / Medium',
                    'price' => 1000,
                    'weight' => 100,
                    'option1' => 'Color',
                    'value1' => 'Blue',
                    'option2' => 'Size',
                    'value2' => 'Medium',
                ],
                [
                    'name' => 'Blue / Large',
                    'price' => 1000,
                    'weight' => 100,
                    'option1' => 'Color',
                    'value1' => 'Blue',
                    'option2' => 'Size',
                    'value2' => 'Large',
                ],
            ],
            'status' => ProductStatusEnum::draft()->value
        ];

        $this
            ->actingAs($this->createUser())
            ->post(route('products.store', $input));
    }
}
