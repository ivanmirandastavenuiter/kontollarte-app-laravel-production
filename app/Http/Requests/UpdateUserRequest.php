<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50'],
            'surname' => ['max:50', 'string', 'nullable'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['regex:/[679]{1}[0-9]{8}/', 'numeric', 'nullable']
        ];
    }

    public function messages() 
    {
        return [
            'name.required' => 'Name field is required.',
            'username.required' => 'Username field is required',
            'email.required' => 'Email field is required',
            'name.string' => 'Name field is not a string',
            'username.string' => 'Username is not a string',
            'surname.string' => 'Surname is not a string',
            'phone.numeric' => 'Phone field has to be numeric',
            'email.string' => 'Email field is not a string',
            'max' => 'Character limit reached',
            'email.email' => 'Error with :attribute format.',
            'phone.refex' => 'Phone number has to be 9 digits, starting by 6, 7 or 9.'
        ];
    }
}
