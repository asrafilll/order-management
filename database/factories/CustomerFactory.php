<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
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
            'name' => 'Customer #' . ++static::$index,
            'phone' => str_pad(
                (string) $this->faker->randomNumber(9),
                12,
                '0',
                STR_PAD_LEFT
            ),
            'address' => '',
            'province' => 'JAWA BARAT',
            'city' => 'BANDUNG',
            'subdistrict' => 'CIBEUNYING KIDUL',
            'village' => 'CICADAS',
            'postal_code' => '40121',
        ];
    }
}
