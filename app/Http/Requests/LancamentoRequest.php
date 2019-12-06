<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LancamentoRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'tipo' => 'required',
            'conta_id' => 'required',
            'fluxo_id' => 'required',
            'valor' => 'required',
            'descricao' => 'max:100',
        ];
    }

    public function messages()
    {
        return [
            'tipo.required' => 'tipo é obrigatorio',
            'conta_id.required' => 'conta é obrigatorio',
            'fluxo_id.required' => 'fluxo é obrigatorio',
            'valor.required' => 'valor é obrigatorio',
            'descricao.max' => 'maximo de caracteres deve ser 100',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
