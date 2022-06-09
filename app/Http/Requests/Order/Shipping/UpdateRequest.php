<?php

namespace App\Http\Requests\Order\Shipping;

use App\Models\Shipping;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                'integer',
                'min:0',
            ],
            'shipping_discount' => [
                'nullable',
                'integer',
                'min:0',
                'max:' . $this->get('shipping_price'),
            ],
        ];
    }
}
