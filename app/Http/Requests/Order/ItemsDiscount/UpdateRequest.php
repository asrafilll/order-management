<?php

namespace App\Http\Requests\Order\ItemsDiscount;

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
        return $this->order->isEditable();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'items_discount' => [
                'required',
                'integer',
                'min:1',
                'max:' . $this->order->items_price,
            ],
        ];
    }
}
