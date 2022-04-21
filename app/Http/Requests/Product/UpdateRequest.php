<?php

namespace App\Http\Requests\Product;

use App\Enums\ProductStatusEnum;
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
                'required_with:options.0.name',
                'array',
            ],
            'variants' => [
                'required',
                'array',
            ],
            'variants.*.name' => [
                'required',
                'string',
            ],
            'variants.*.option1' => [
                'required',
                'string',
            ],
            'variants.*.value1' => [
                'required',
                'string',
            ],
            'variants.*.option2' => [
                'nullable',
                'string',
            ],
            'variants.*.value2' => [
                'nullable',
                'string',
            ],
            'variants.*.price' => [
                'required',
                'numeric',
                'min:1',
            ],
            'variants.*.weight' => [
                'required',
                'numeric',
                'min:1'
            ],
            'status' => [
                'required',
                'enum:' . ProductStatusEnum::class,
            ]
        ];
    }

    /**
     * @return array
     */
    public function getProductAttribute()
    {
        return [
            'name' => $this->get('name'),
            'description' => $this->get('description'),
            'status' => $this->get('status'),
        ];
    }

    /**
     * @return array
     */
    public function getProductOptionsAttributes()
    {
        return array_map(fn (array $option) => [
            'name' => $option['name'],
            'values' => json_encode($option['values']),
        ], $this->get('options'));
    }

    /**
     * @return array
     */
    public function getProductVariantsAttributes()
    {
        return $this->get('variants');
    }
}
