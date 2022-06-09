<?php

namespace App\Http\Requests\Order\Item;

use App\Models\ProductVariant;
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
            'variant_id' => [
                'required',
                'integer',
                Rule::exists((new ProductVariant())->getTable(), 'id'),
            ],
        ];
    }
}
