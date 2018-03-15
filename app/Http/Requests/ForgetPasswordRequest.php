<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
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
            'email' => 'email|required'
        ];
    }

    /**
     * Get translated messages for current validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.email' => 'Email adresa nije ispravna',
            'email.required' => 'Email adresa je obavezna',
        ];
    }
}
