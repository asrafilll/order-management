<?php

namespace Tests\Utils;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Order;
use App\Models\OrderSource;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Shipping;
use Illuminate\Support\Carbon;

class OrderBuilder
{
    private array $attributes = [];

    private bool $addItem = false;

    public function __construct()
    {
        /** @var OrderSource */
        $orderSource = OrderSource::factory()->create();
        /** @var Customer */
        $customer = Customer::factory()->create();

        $this->addAttributes([
            'source_id' => $orderSource->id,
            'source_name' => $orderSource->name,
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_phone' => $customer->phone,
            'customer_address' => $customer->address,
            'customer_province' => $customer->province,
            'customer_city' => $customer->city,
            'customer_subdistrict' => $customer->subdistrict,
            'customer_village' => $customer->village,
            'customer_postal_code' => $customer->postal_code,
            'status' => $orderStatusEnum ?? OrderStatusEnum::waiting(),
        ]);
    }

    public function addSales(): OrderBuilder
    {
        /** @var Employee */
        $sales = Employee::factory()->create();

        $this->addAttributes([
            'sales_id' => $sales->id,
            'sales_name' => $sales->name,
        ]);

        return $this;
    }

    public function addCreator(): OrderBuilder
    {
        /** @var Employee */
        $creator = Employee::factory()->create();

        $this->addAttributes([
            'creator_id' => $creator->id,
            'creator_name' => $creator->name,
        ]);

        return $this;
    }

    public function addPacker(): OrderBuilder
    {
        /** @var Employee */
        $packer = Employee::factory()->create();

        $this->addAttributes([
            'packer_id' => $packer->id,
            'packer_name' => $packer->name,
        ]);

        return $this;
    }

    public function addPaymentMethod(): OrderBuilder
    {
        /** @var PaymentMethod */
        $payment_method = PaymentMethod::factory()->create();

        $this->addAttributes([
            'payment_method_id' => $payment_method->id,
            'payment_method_name' => $payment_method->name,
            'payment_status' => PaymentStatusEnum::paid(),
        ]);

        return $this;
    }

    public function addShipping(): OrderBuilder
    {
        /** @var Shipping */
        $shipping = Shipping::factory()->create();

        $this->addAttributes([
            'shipping_id' => $shipping->id,
            'shipping_name' => $shipping->name,
            'shipping_price' => 10000,
        ]);

        return $this;
    }

    public function addShippingDetail(): OrderBuilder
    {
        $this->addAttributes([
            'shipping_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'shipping_airwaybill' => 'EXAMPLEAIRWAYBILL',
        ]);

        return $this;
    }

    public function addItems(): OrderBuilder
    {
        $this->addItem = true;

        return $this;
    }

    public function setStatus(OrderStatusEnum $orderStatusEnum): OrderBuilder
    {
        $this->attributes['status'] = $orderStatusEnum->value;

        return $this;
    }

    private function addAttributes(array $attributes): OrderBuilder
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }

    public function build(): Order
    {
        /** @var Order */
        $order = Order::create($this->attributes);

        if (!$this->addItem) {
            $order->refresh();

            return $order;
        }

        /** @var Product */
        $product = Product::factory()->create();
        $product
            ->options()
            ->create([
                'name' => 'Color',
                'values' => json_encode([
                    'Red',
                ])
            ]);
        $product
            ->variants()
            ->createMany([
                [
                    'name' => 'Red',
                    'price' => 10000,
                    'weight' => 1000,
                    'option1' => 'Color',
                    'value1' => 'Red',
                ],
            ]);

        /** @var ProductVariant */
        $productVariant = ProductVariant::with(['product'])->first();

        $order
            ->items()
            ->create([
                'product_id' => $productVariant->product_id,
                'product_slug' => $productVariant->product->slug,
                'product_name' => $productVariant->product->name,
                'product_description' => $productVariant->product->description,
                'variant_id' => $productVariant->id,
                'variant_name' => $productVariant->name,
                'variant_price' => $productVariant->price,
                'variant_weight' => $productVariant->weight,
                'variant_option1' => $productVariant->option1,
                'variant_value1' => $productVariant->value1,
                'variant_option2' => $productVariant->option2,
                'variant_value2' => $productVariant->value2,
                'quantity' => 1,
            ]);

        $order->refresh();

        return $order;
    }
}
