<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class FluxoRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            'descricao' => 'required|unique:fluxos',
            'tipo' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'descricao.required' => 'Descricao é obrigatoria',
            'descricao.unique' => 'fluxo ja existe',
            'tipo.required' => 'tipo é obrigatorio'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

}
