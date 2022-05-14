<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MetaFactory extends Factory
{
    public static int $index = 0;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $index = ++static::$index;

        return [
            'key' => 'meta-key-' . $index,
            'value' => 'meta value ' . $index,
        ];
    }
}
