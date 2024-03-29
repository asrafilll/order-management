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
            'items_discount' => [
                'required',
                'integer',
                'min:0',
                'max:' . $this->order->items_price,
            ],
        ];
    }
}
