<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderSource;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReturnOrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /** @var OrderSource */
        $source = OrderSource::count() < 1
            ? OrderSource::factory()->create()
            : OrderSource::first();

        /** @var Customer */
        $customer = Customer::count() < 1
            ? Customer::factory()->create()
            : Customer::first();

        /** @var Order */
        $order = Order::count() < 1
            ? Order::factory()->state([
                'source_id' => $source->id,
                'source_name' => $source->name,
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone,
                'customer_address' => $customer->address,
                'customer_province' => $customer->province,
                'customer_city' => $customer->city,
                'customer_subdistrict' => $customer->subdistrict,
                'customer_village' => $customer->village,
                'customer_postal_code' => $customer->postal_code,
            ])
            ->has(OrderItem::factory(), 'items')
            ->create()
            : Order::with(['items'])->first();

        return [
            'order_id' => $order->id,
            'order_item_id' => $order->items->first()->id,
            'quantity' => 1,
            'reason' => 'Example return reason',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function published()
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => Carbon::now(),
        ]);
    }
}
