<?php

namespace App\Http\Requests\ReturnOrderItem;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_id' => [
                'required',
                'integer',
                Rule::exists((new Order)->getTable(), 'id')
                    ->where('status', OrderStatusEnum::completed()->value),
            ],
            'order_item_id' => [
                'required',
                'integer',
                Rule::exists((new OrderItem)->getTable(), 'id'),
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'reason' => [
                'nullable',
                'string',
            ],
            'publish' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    /**
     * @return array
     */
    public function validated()
    {
        return [
            'order_id' => $this->get('order_id'),
            'order_item_id' => $this->get('order_item_id'),
            'quantity' => $this->get('quantity'),
            'reason' => $this->get('reason'),
            'published_at' => $this->get('publish') ? Carbon::now() : null,
        ];
    }
}
