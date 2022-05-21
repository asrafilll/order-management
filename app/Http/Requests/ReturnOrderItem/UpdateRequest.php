<?php

namespace App\Http\Requests\ReturnOrderItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

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
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'reason' => [
                'nullable',
                'string',
            ],
            'publish' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    /**
     * @return array
     */
    public function validated()
    {
        return [
            'quantity' => $this->get('quantity'),
            'reason' => $this->get('reason'),
            'published_at' => $this->get('publish') ? Carbon::now() : null,
        ];
    }
}
