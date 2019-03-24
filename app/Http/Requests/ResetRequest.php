<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string']
            
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email field is required',
            'password.required' => 'Password field is required',
            'password_confirmation.required' => 'Confirm password',
            'email.string' => 'Email has to be a string',
            'password.string' => 'Password has to be a string',
            'password_confirmation.string' => 'Password confirm has to be a string',
            'email.email' => 'Invalid format',
            'password.min' => 'Password has to be at least 8 characters'
        ];
    }
}
