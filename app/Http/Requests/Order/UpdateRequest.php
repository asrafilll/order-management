<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderStatusEnum;
use App\Models\Customer;
use App\Models\Shipping;
use App\Models\OrderSource;
use App\Models\PaymentMethod;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->order->status->equals(OrderStatusEnum::draft());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'source_id' => [
                'required',
                'integer',
                Rule::exists((new OrderSource())->getTable(), 'id'),
            ],
            'source_name' => [
                'required',
                'string',
            ],
            'customer_id' => [
                'required',
                'integer',
                Rule::exists((new Customer())->getTable(), 'id'),
            ],
            'customer_name' => [
                'required',
                'string',
            ],
            'customer_phone' => [
                'required',
                'numeric',
            ],
            'customer_address' => [
                'required',
                'string',
            ],
            'customer_province' => [
                'required',
                'string',
            ],
            'customer_city' => [
                'required',
                'string',
            ],
            'customer_subdistrict' => [
                'required',
                'string',
            ],
            'customer_village' => [
                'required',
                'string',
            ],
            'customer_postal_code' => [
                'required',
                'numeric',
            ],
            'payment_method_id' => [
                'required',
                'integer',
                Rule::exists((new PaymentMethod())->getTable(), 'id'),
            ],
            'payment_method_name' => [
                'required',
                'string',
            ],
            'shipping_id' => [
                'required',
                'integer',
                Rule::exists((new Shipping())->getTable(), 'id'),
            ],
            'shipping_name' => [
                'required',
                'string',
            ],
            'shipping_price' => [
                'required',
                'numeric',
            ],
            'note' => [
                'nullable',
                'string',
            ],
            'sales_name' => [
                'required',
                'string',
            ],
            'creator_name' => [
                'required',
                'string',
            ],
            'packer_name' => [
                'required',
                'string',
            ],
        ];
    }
}
