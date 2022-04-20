<?php

namespace App\Http\Requests\Product;

use App\Enums\ProductStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

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
            'name' => [
                'required',
                'string',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'options' => [
                'required',
                'array',
            ],
            'options.0.name' => [
                'required',
                'string',
            ],
            'options.0.values' => [
                'required_with:options.*.name',
                'array',
            ],
            'variants' => [
                'required',
                'array',
            ],
            'variants.*.price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'variants.*.weight' => [
                'required',
                'numeric',
                'min:0'
            ],
            'status' => [
                'required',
                'enum:' . ProductStatusEnum::class,
            ]
        ];
    }
}
