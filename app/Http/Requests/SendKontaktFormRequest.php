<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendKontaktFormRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ime je obavezno.',
            'email.required' => 'Email adresa je obavezna.',
            'email.email' => 'Email adresa nije u ispravnom formatu',
            'message.required' => 'Tekst poruke je obavezan.',
        ];
    }
}
