<?php

namespace App\Http\Requests\Order\Contributors;

use App\Models\Employee;
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
            'sales_id' => [
                'required',
                'integer',
                Rule::exists((new Employee())->getTable(), 'id'),
            ],
            'sales_name' => [
                'required',
                'string',
            ],
            'creator_id' => [
                'required',
                'integer',
                Rule::exists((new Employee())->getTable(), 'id'),
            ],
            'creator_name' => [
                'required',
                'string',
            ],
            'packer_id' => [
                'required',
                'integer',
                Rule::exists((new Employee())->getTable(), 'id'),
            ],
            'packer_name' => [
                'required',
                'string',
            ],
        ];
    }
}
