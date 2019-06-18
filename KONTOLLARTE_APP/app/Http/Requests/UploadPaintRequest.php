<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UploadPaintRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
            'image' => ['required', 'image', 'max:1000']
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
            'date.required' => 'Date field is required',
            'description.required' => 'Description field is required',
            'image.required' => 'Image file needs to be uploaded',
            'title.string' => 'Title field is not a string',
            'date.date' => 'Date is not a date type',
            'description.string' => 'Description is not a string',
            'image.image' => 'File has to be image type',
            'title.max' => 'Character limit reached',
            'image.max' => 'Maximum size permitted: 1000 KB',
            'title.unique' => 'Title field already detected on database'
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
                    ->errorBag('uploadError')
                    ->redirectTo($this->getRedirectUrl());
    }



}
