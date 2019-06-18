<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendPasswordRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255']
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
            'required' => 'Email is required',
            'string' => 'Parameter introduced is not a string',
            'email' => 'Invalid format',
            'max' => 'Character limit reached'
        ];
    }
}
