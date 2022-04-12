<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'price' => $this->faker->randomNumber(5),
            'weight' => $this->faker->randomNumber(2),
        ];
    }

    /**
     * Indicate that product variant has dimension.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function dimension()
    {
        return $this->state(fn (array $attributes) => [
            'width' => $this->faker->randomNumber(2),
            'height' => $this->faker->randomNumber(2),
            'length' => $this->faker->randomNumber(2),
        ]);
    }
}
