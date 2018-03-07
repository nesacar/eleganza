<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMessageRequest extends FormRequest
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
            'product_id' => 'required|numeric',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Product ID je obavezan',
            'product_id.numeric' => 'Product ID nije broj',
            'name.required' => 'Ime je obavezno',
            'email.required' => 'Email je obavezan',
            'phone.required' => 'Telefon je obavezan',
            'message.required' => 'Poruka je obavezna',
        ];
    }
}
