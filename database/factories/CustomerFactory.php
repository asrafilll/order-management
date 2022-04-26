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
                (string) $this->faker->randomNumber(12),
                12,
                '0',
                STR_PAD_LEFT
            ),
            'address' => '',
            'province_code' => '32',
            'province_name' => 'JAWA BARAT',
            'city_code' => '3273',
            'city_name' => 'BANDUNG',
            'subdistrict_code' => '3273210',
            'subdistrict_name' => 'CIBEUNYING KIDUL',
            'village_code' => '3273210002',
            'village_name' => 'CICADAS',
            'postal_code' => '40121',
        ];
    }
}
