<?php

namespace Database\Factories;

use App\Enums\ProductStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->randomHtml(),
            'status' => $this->faker->randomElement(ProductStatusEnum::toValues())
        ];
    }
}
