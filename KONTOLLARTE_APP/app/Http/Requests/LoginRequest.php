<?php

namespace App\Http\Requests;

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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string']
        ];
    }

    /**
     * Return the messages that will display in case of errors.
     *
     * @return array
     */
    public function messages() 
    {
        return [
            'email.required' => 'Email field is required.   ',
            'password.required' => 'Password field is required.',
            'email.string' => 'Email field is not a string',
            'password.string' => 'Password field is not a string',
            'email.email' => 'Error with :attribute format.',
            'email.max' => 'Email is too long.'
        ];
    }
}
