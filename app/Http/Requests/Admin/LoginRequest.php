<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'mobile' => 'required|numeric|digits:10|exists:users,mobile',
            'password' => 'required',
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
            'mobile.required' => 'Please enter mobile.',
            'mobile.numeric' => 'Please enter only numbers.',
            'mobile.digits' => 'Please enter only 10 digits.',
            'password.required' => 'Please enter password.',
        ];
    }
}
