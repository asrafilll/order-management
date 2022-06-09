<?php

namespace App\Http\Requests\Order\Payment;

use App\Enums\PaymentStatusEnum;
use App\Models\PaymentMethod;
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
            'payment_status' => [
                'required',
                'string',
                'enum:' . PaymentStatusEnum::class,
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
        ];
    }
}
