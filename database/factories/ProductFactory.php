<?php

namespace Database\Factories;

use App\Enums\ProductStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public static int $index = 0;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Product #' . ++static::$index,
            'description' => $this->faker->randomHtml(),
            'status' => $this->faker->randomElement(ProductStatusEnum::toValues())
        ];
    }
}
