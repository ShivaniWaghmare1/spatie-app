<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:permissions,name,' . $this->route('id'),
        ];
    }

    /**
     * Get the validation error messages that apply to the request
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Please enter name.',
            'name.string' => 'Please enter only string.',
            'name.max' => 'Name character limit exceeds.',
            'name.unique' => 'Name already exists.',
        ];
    }
}
