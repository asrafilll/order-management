<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
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
            'name' => 'Variant #' . ++static::$index,
            'price' => $this->faker->randomNumber(5),
            'weight' => $this->faker->randomNumber(2),
        ];
    }
}
