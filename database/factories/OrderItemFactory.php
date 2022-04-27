<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $number = $this->faker->randomNumber(1);

        return [
            'product_id' => 1,
            'product_name' => 'Product #' . $number,
            'product_slug' => 'product-' . $number,
            'product_description' => $this->faker->text(30),
            'variant_id' => 1,
            'variant_name' => 'Red',
            'variant_price' => 5000,
            'variant_weight' => 200,
            'variant_option1' => 'Color',
            'variant_value1' => 'Red',
            'quantity' => 2,
        ];
    }
}
