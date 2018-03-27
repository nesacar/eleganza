<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetCouponRequest extends FormRequest
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
            'coupon' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'coupon.required' => 'Kupon je obavezan'
        ];
    }
}
