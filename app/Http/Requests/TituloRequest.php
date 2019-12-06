<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TituloRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'cedente' => 'required',
            'conta_id' => 'required',
            'fluxo_id' => 'required',
            'valor' => 'required',
            'sacado' => 'max:100',
            'tipo' => 'required',
            'status' => 'required',
            'vencimento' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cedente.required' => 'cedente obrigatorio',
            'conta_id.required' => 'conta obrigatorio',
            'fluxo_id.required' => 'fluxo obrigatorio',
            'valor.required' => 'valor obrigatorio',
            'sacado.required' => 'sacado obrigatorio',
            'tipo.required' => 'tipo obrigatorio',
            'status.required' => 'status obrigatorio',
            'vencimento.required' => 'vencimento obrigatorio',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
