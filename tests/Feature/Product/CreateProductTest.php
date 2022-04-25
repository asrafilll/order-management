<?php

namespace Tests\Feature\Product;

use App\Enums\PermissionEnum;
use App\Enums\ProductStatusEnum;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\Utils\UserFactory;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;
    use UserFactory;

    /**
     * @dataProvider validProvider
     * @param array $input
     * @return void
     */
    public function test_should_success_create_product(array $input)
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_products()
                )
            )
            ->post(route('products.store', $input));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        /** @var Product */
        $product = Product::whereName($input['name'])->first();

        $this->assertEquals($input['name'], $product->name);
        $this->assertEquals(Str::slug($input['name']), $product->slug);

        if (isset($input['description'])) {
            $this->assertEquals($input['description'], $product->description);
        }

        $this->assertEquals($input['status'], $product->status);

        /** @var Collection<ProductOption> */
        $productOptions = ProductOption::whereProductId($product->id)->get();

        foreach ($productOptions as $index => $productOption) {
            $values = array_reduce($input['options'][$index]['values'], function (array $acc, $value) {
                if (!is_null($value)) {
                    array_push($acc, $value);
                }
                return $acc;
            }, []);
            $this->assertEquals($input['options'][$index]['name'], $productOption->name);
            $this->assertEquals(json_encode($values), $productOption->values);
        }

        /** @var Collection<ProductVariant> */
        $productVariants = ProductVariant::whereProductId($product->id)->get();

        foreach ($productVariants as $index => $productVariant) {
            $this->assertEquals($input['variants'][$index]['name'], $productVariant->name);
            $this->assertEquals($input['variants'][$index]['price'], $productVariant->price);
            $this->assertEquals($input['variants'][$index]['weight'], $productVariant->weight);
            $this->assertEquals($input['variants'][$index]['option1'], $productVariant->option1);
            $this->assertEquals($input['variants'][$index]['value1'], $productVariant->value1);
            $this->assertEquals($input['variants'][$index]['option2'], $productVariant->option2);
            $this->assertEquals($input['variants'][$index]['value2'], $productVariant->value2);
        }
    }

    public function validProvider()
    {
        return [
            'all fields are filled' => [
                [
                    'name' => 'Sample Product #1',
                    'description' => 'This is sample product 1 description',
                    'options' => [
                        [
                            'name' => 'Color',
                            'values' => [
                                'Red',
                                'Green',
                                null,
                            ],
                        ],
                        [
                            'name' => 'Size',
                            'values' => [
                                'Small',
                                null,
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
                            'name' => 'Green / Small',
                            'price' => 1000,
                            'weight' => 100,
                            'option1' => 'Color',
                            'value1' => 'Green',
                            'option2' => 'Size',
                            'value2' => 'Small',
                        ],
                    ],
                    'status' => ProductStatusEnum::draft()->value
                ],
            ],
            'description: null' => [
                [
                    'name' => 'Sample Product #1',
                    'options' => [
                        [
                            'name' => 'Color',
                            'values' => [
                                'Red',
                                'Green',
                            ],
                        ],
                        [
                            'name' => 'Size',
                            'values' => [
                                'Small',
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
                            'name' => 'Green / Small',
                            'price' => 1000,
                            'weight' => 100,
                            'option1' => 'Color',
                            'value1' => 'Green',
                            'option2' => 'Size',
                            'value2' => 'Small',
                        ],
                    ],
                    'status' => ProductStatusEnum::draft()->value
                ],
            ],
            'options rows just one' => [
                [
                    'name' => 'Sample Product #1',
                    'description' => 'This is sample product 1 description',
                    'options' => [
                        [
                            'name' => 'Color',
                            'values' => [
                                'Red',
                                'Green',
                            ],
                        ],
                        [
                            'name' => null,
                            'values' => [
                                null
                            ],
                        ],
                    ],
                    'variants' => [
                        [
                            'name' => 'Red',
                            'price' => 1000,
                            'weight' => 100,
                            'option1' => 'Color',
                            'value1' => 'Red',
                            'option2' => null,
                            'value2' => null,
                        ],
                        [
                            'name' => 'Green',
                            'price' => 1000,
                            'weight' => 100,
                            'option1' => 'Color',
                            'value1' => 'Green',
                            'option2' => null,
                            'value2' => null,
                        ],
                    ],
                    'status' => ProductStatusEnum::draft()->value
                ],
            ]
        ];
    }

    /**
     * @dataProvider invalidProvider
     * @param array $input
     * @param array $errors
     * @return void
     */
    public function test_should_error_create_product(
        array $input,
        array $errors
    ) {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_products()
                )
            )
            ->post(route('products.store', $input));

        $response
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
    }

    /**
     * @return array
     */
    public function invalidProvider()
    {
        return [
            'name: null, options: null, variants: null, status: null' => [
                [],
                [
                    'name',
                    'options',
                    'variants',
                    'status'
                ],
            ],
            'options: (not array), variants: (not array)' => [
                [
                    'name' => 'Sample Product #1',
                    'description' => 'This is sample product 1 description',
                    'options' => 'some-string',
                    'variants' => 'some-string',
                    'status' => ProductStatusEnum::draft()->value
                ],
                [
                    'options',
                    'variants',
                ],
            ],
            'options.0.name: null, variants: null' => [
                [
                    'name' => 'Sample Product #1',
                    'description' => 'This is sample product 1 description',
                    'options' => [],
                    'variants' => [],
                    'status' => ProductStatusEnum::draft()->value
                ],
                [
                    'options.0.name',
                ],
            ],
            'options.0.values: null, variants: null' => [
                [
                    'name' => 'Sample Product #1',
                    'description' => 'This is sample product 1 description',
                    'options' => [
                        [
                            'name' => 'Color',
                        ],
                    ],
                    'variants' => [],
                    'status' => ProductStatusEnum::draft()->value
                ],
                [
                    'options.0.values',
                    'variants',
                ],
            ],
            'variants.0.price: null, variants.0.weight: null, option1: null, value1: null' => [
                [
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
                    ],
                    'variants' => [
                        [
                            'name' => 'test',
                            'price' => null,
                            'weight' => null,
                            'option1' => null,
                            'value1' => null,
                        ],
                    ],
                    'status' => ProductStatusEnum::draft()->value
                ],
                [
                    'variants.0.price',
                    'variants.0.weight',
                    'variants.0.option1',
                    'variants.0.value1',
                ],
            ],
            'variants.0.price: 0, variants.0.weight: 0' => [
                [
                    'name' => 'Sample Product #1',
                    'description' => 'This is sample product 1 description',
                    'options' => [
                        [
                            'name' => 'Color',
                            'values' => [
                                'Red',
                            ],
                        ],
                    ],
                    'variants' => [
                        [
                            'name' => 'test',
                            'price' => 0,
                            'weight' => 0,
                            'option1' => 'Color',
                            'value1' => 'Red',
                        ],
                    ],
                    'status' => ProductStatusEnum::draft()->value
                ],
                [
                    'variants.0.price',
                    'variants.0.weight',
                ],
            ],
        ];
    }
}
