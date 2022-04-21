<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductOptionFactory extends Factory
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
            'name' => 'Option #' . ++static::$index,
            'values' => json_encode(['Value #1', 'Value #2', 'Value #3']),
        ];
    }
}
