<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCouponRequest extends FormRequest
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
            'publish_at' => 'required',
            'valid_at' => 'required',
            'discount' => 'required|integer|min:0',
            'number' => 'required|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'publish_at.required' => 'Aktivno od je obavezno',
            'valid_at.required' => 'Aktivno do je obavezno',
            'discount.required' => 'Popust je obavezan',
            'discount.integer' => 'Popust mora biti broj',
            'discount.min' => 'Popust mora biti pozitivan broj',
            'number.required' => 'Broj kupona je obavezan',
            'number.integer' => 'Broj kupona mora biti broj',
            'number.min' => 'Broj kupona mora biti pozitivan broj',
        ];
    }
}
