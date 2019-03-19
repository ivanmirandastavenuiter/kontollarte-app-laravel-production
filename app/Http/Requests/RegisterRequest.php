<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => [ 'required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages() 
    {
        return [
            'name.required' => 'Name field is required.',
            'email.required' => 'Email field is required',
            'password.required' => 'Password field is required.',
            'name.string' => 'Name field is not a string',
            'email.string' => 'Email field is not a string',
            'password.string' => 'Password field is not a string',
            'name.max' => 'Character limit reached',
            'password.min' => 'Password must have at least 8 characters',
            'password.confirmed' => 'Passwords do not match',
            'name.unique' => 'Name already detected on the database',
            'email.unique' => 'Email already detected on the database',
            'email.email' => 'Error with :attribute format.'

        ];
    }
}
