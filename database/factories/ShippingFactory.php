<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingFactory extends Factory
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
            'name' => 'Shipping #' . ++static::$index,
        ];
    }
}
