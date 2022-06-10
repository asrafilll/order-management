<?php

namespace Database\Factories;

use App\Enums\ReturnOrderStatusEnum;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReturnOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Order::factory(),
            'status' => ReturnOrderStatusEnum::at_warehouse(),
        ];
    }
}
