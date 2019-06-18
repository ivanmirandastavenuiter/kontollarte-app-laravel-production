<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class SellPaintRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string', 'min:10', 'max:255']
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
            'title.required' => 'Title field is required.',
            'price.required' => 'Price field is required',
            'description.required' => 'Description field is required',
            'title.string' => 'Title field is not a string',
            'price.numeric' => 'Price field is not numeric',
            'description.string' => 'Description is not a string',
            'title.max' => 'Character limit reached',
            'description.min' => 'Minimum length is 10',
            'description.max' => 'Maximum length reached'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
    }

    /**
     * Get the URL to redirect to on a validation error.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        return $this->validationData()['currentPath']."?". 
               "paintId=".$this->validationData()['paintId']. 
               "&failed=true";
    }



}
