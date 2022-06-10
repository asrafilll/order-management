<?php

namespace App\Http\Requests\ReturnOrder\Item;

use App\Models\OrderItem;
use App\Models\ReturnOrderItem;
use Illuminate\Foundation\Http\FormRequest;
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
            'order_item_id' => [
                'required',
                'integer',
                Rule::exists((new OrderItem())->getTable(), 'id'),
                Rule::unique((new ReturnOrderItem())->getTable(), 'order_item_id')
                    ->where('return_order_id', $this->returnOrder->id),
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
        ];
    }
}
