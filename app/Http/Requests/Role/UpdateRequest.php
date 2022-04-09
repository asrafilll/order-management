<?php

namespace App\Http\Requests\Role;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

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
                Rule::unique((new Role())->getTable(), 'name')->ignore($this->role),
            ],
            'permissions' => [
                'array',
            ],
            'permissions.*' => [
                'integer',
                Rule::exists((new Permission())->getTable(), 'id')
            ],
        ];
    }
}
