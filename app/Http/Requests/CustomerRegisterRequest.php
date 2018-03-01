<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRegisterRequest extends FormRequest
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
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed',
            'name' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'town' => 'required',
            'postcode' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email adresa je obavezna.',
            'email.unique' => 'Email adresa je zauteta. Pokušajte sa drugom.',
            'password.required' => 'Lozinka je obavezna.',
            'password.confirmed' => 'Niste dobro potvrdili lozinku, pokušajte ponovo.',
            'name.required' => 'Ime je obavezno.',
            'lastname.required' => 'Prezime je obavezno.',
            'address.required' => 'Adresa je obavezna.',
            'phone.required' => 'Telefon je obavezan.',
            'town.required' => 'Mjesto je obavezano.',
            'postcode.required' => 'Poštanski broj je obavezan.',
        ];
    }
}
