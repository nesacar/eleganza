<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBannerRequest extends FormRequest
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
            'link' => 'required',
            'width' => 'required',
            'height' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Naziv banera je obavezan.',
            'link.required' => 'Link je obavezan.',
            'width.required' => 'Širina je obavezna.',
            'height.required' => 'Visina je obavezna.'
        ];
    }
}
