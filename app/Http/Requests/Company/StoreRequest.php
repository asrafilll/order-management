<?php

namespace App\Http\Requests\Company;

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
            'phone' => [
                'required',
                'numeric',
            ],
            'address' => [
                'required',
                'string',
            ],
            'province' => [
                'required',
                'string',
            ],
            'city' => [
                'required',
                'string',
            ],
            'subdistrict' => [
                'required',
                'string',
            ],
            'village' => [
                'required',
                'string',
            ],
            'postal_code' => [
                'required',
                'string',
            ],
        ];
    }
}
