<?php

namespace App\Http\Requests\OrderSource;

use App\Models\OrderSource;
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
            'name' => [
                'required',
                'string',
            ],
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists((new OrderSource())->getTable(), 'id'),
            ],
        ];
    }
}
