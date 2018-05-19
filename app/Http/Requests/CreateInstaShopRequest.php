<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInstaShopRequest extends FormRequest
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
            'title' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif',
            'order' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Naziv je obavezan',
            'image.required' => 'Slika je obavezna',
            'image.image' => 'Niste uploudovali sliku',
            'image.mimes' => 'Slika mora biti u jpg, jpeg, png ili gif formatu',
            'order.required' => 'Redosled je obavezan',
        ];
    }
}
