<?php

namespace App\Http\Requests;

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;

class EditSubscriberRequest extends FormRequest
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
            'email' => 'required|email|unique:subscribers,id,'.$this->segment(3),
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email adresa je obavezna.',
            'email.email' => 'Format email adrese nije ispravan.',
            'email.unique' => 'Email adresa vec postoji.'
        ];
    }
}
