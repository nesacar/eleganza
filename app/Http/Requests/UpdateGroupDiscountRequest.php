<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupDiscountRequest extends FormRequest
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
            'discount' => 'required|numeric|min:0',
            'all' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'discount.required' => 'Popust je obavezan.',
            'discount.numeric' => 'Popust mora biti broj.',
            'discount.min' => 'Popust mora biti pozitivan broj.',
            'all.required' => 'Niste obeležili proizvode.',
        ];
    }
}
