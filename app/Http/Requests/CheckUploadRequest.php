<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckUploadRequest extends FormRequest
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
            'file' => 'required|mimes:xlsx,xls'
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Fajl u excel formatu je obavezan.',
            'file.mimes' => 'Fajl nije u excel formatu.'
        ];
    }
}
