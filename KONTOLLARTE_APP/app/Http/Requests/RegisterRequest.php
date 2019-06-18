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
            'name' => ['required', 'string', 'max:50', 'unique:users'],
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'surname' => ['max:50', 'string', 'nullable'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['regex:/[679]{1}[0-9]{8}/', 'unique:users', 'numeric', 'nullable'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
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
            'name.required' => 'Name field is required.',
            'username.required' => 'Username field is required',
            'email.required' => 'Email field is required',
            'password.required' => 'Password field is required.',
            'name.string' => 'Name field is not a string',
            'username.string' => 'Username is not a string',
            'surname.string' => 'Surname is not a string',
            'phone.numeric' => 'Phone field has to be numeric',
            'email.string' => 'Email field is not a string',
            'password.string' => 'Password field is not a string',
            'max' => 'Character limit reached',
            'password.min' => 'Password must have at least 8 characters',
            'name.unique' => 'Name already detected on the database',
            'username.unique' => 'Username already detected on the database',
            'email.unique' => 'Email already detected on the database',
            'phone.unique' => 'Phone already detected on the database',
            'password.confirmed' => 'Passwords do not match',
            'email.email' => 'Error with :attribute format.',
            'phone.refex' => 'Phone number has to be 9 digits, starting by 6, 7 or 9.'
        ];
    }
}
