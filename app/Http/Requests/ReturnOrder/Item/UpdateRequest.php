<?php

namespace App\Http\Requests\ReturnOrder\Item;

use App\Models\OrderItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return intval($this->returnOrder->id) === intval($this->returnOrderItem->return_order_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
        $orderItem = $this->returnOrderItem->orderItem;

        if (!$orderItem) {
            throw ValidationException::withMessages([
                'order_item_id' => __('validation.exists' . [
                    'attribute' => 'order_item_id',
                ]),
            ]);
        }

        $unreturnQuantity = $orderItem->getUnreturnQuantity() + $this->returnOrderItem->quantity;

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
