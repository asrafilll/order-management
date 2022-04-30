<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => OrderStatusEnum::waiting()->value,
            'source_id' => 1,
            'source_name' => 'Marketplace',
            'customer_id' => 1,
            'customer_name' => 'Customer #1',
            'customer_phone' => str_pad(
                (string) $this->faker->randomNumber(9),
                12,
                '0',
                STR_PAD_LEFT
            ),
            'customer_address' => 'CICADAS, CIBEUNYING KIDUL, BANDUNG, JAWA BARAT 40121',
            'customer_province' => 'JAWA BARAT',
            'customer_city' => 'BANDUNG',
            'customer_subdistrict' => 'CIBEUNYING KIDUL',
            'customer_village' => 'CICADAS',
            'customer_postal_code' => '40121',
            'payment_method_id' => 1,
            'payment_method_name' => 'Cash',
            'payment_status' => PaymentStatusEnum::unpaid()->value,
            'shipping_id' => 1,
            'shipping_name' => 'SICEPAT - REGULER',
            'items_quantity' => 3,
            'items_price' => 30000,
            'shipping_price' => 10000,
            'total_price' => 40000,
            'note' => $this->faker->text(30),
            'sales_name' => 'John Sales',
            'creator_name' => 'John Creator',
            'packer_name' => 'John Packer',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function itemsDiscount()
    {
        return $this->state(fn (array $attributes) => [
            'items_discount' => 5000,
            'total_price' => $attributes['total_price'] - 5000,
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function shippingDiscount()
    {
        return $this->state(fn (array $attributes) => [
            'shipping_discount' => 5000,
            'total_price' => $attributes['total_price'] - 5000,
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function waiting()
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatusEnum::waiting()->value,
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function processed()
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatusEnum::processed()->value,
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function sent()
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatusEnum::sent()->value,
            'shipping_date' => Carbon::now()
                ->addHours(1)
                ->format('Y-m-d'),
            'shipping_airwaybill' => 'SAMPLEAWB12345',
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function completed()
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatusEnum::completed()->value,
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function canceled()
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatusEnum::canceled()->value,
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function returnedToWarehouse()
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatusEnum::returned_to_warehouse()->value,
            'returned_at' => Carbon::now()->subDays(1),
            'returned_note' => 'Item not match.',
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function returnedToExpedition()
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatusEnum::returned_to_warehouse()->value,
            'returned_at' => Carbon::now()->subDays(1),
            'returned_note' => 'Address not found.',
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function lost()
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatusEnum::lost()->value,
        ]);
    }
}
