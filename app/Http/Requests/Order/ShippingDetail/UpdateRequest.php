<?php

namespace App\Http\Requests\Order\ShippingDetail;

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
            'shipping_date' => [
                'required',
                'string',
                'date_format:Y-m-d H:i:s',
            ],
            'shipping_airwaybill' => [
                'required',
                'string',
            ],
        ];
    }
}