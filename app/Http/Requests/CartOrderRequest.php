<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartOrderRequest extends FormRequest
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
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'town' => 'required',
            'postcode' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ime je obavezno.',
            'lastname.required' => 'Prezime je obavezno.',
            'email.required' => 'Email adresa je obavezna.',
            'phone.required' => 'Broj telefona je obavezan.',
            'address.required' => 'Adresa je obavezna.',
            'town.required' => 'Grad je obavezan.',
            'postcode.required' => 'Poštanski broj je obavezan.'
        ];
    }
}
