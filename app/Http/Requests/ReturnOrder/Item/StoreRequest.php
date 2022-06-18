<?php

namespace App\Http\Requests\ReturnOrder\Item;

use App\Models\OrderItem;
use App\Models\ReturnOrderItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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

    protected function prepareForValidation()
    {
        /** @var OrderItem */
        $orderItem = OrderItem::find($this->get('order_item_id'));

        if (!$orderItem) {
            throw ValidationException::withMessages([
                'order_item_id' => __('validation.exists' . [
                    'attribute' => 'order_item_id',
                ]),
            ]);
        }

        $unreturnQuantity = $orderItem->getUnreturnQuantity();

        if ($unreturnQuantity < $this->get('quantity')) {
            throw ValidationException::withMessages([
                'quantity' => __('validation.max.numeric', [
                    'attribute' => 'quantity',
                    'max' => $unreturnQuantity,
                ]),
            ]);
        }
    }
}
