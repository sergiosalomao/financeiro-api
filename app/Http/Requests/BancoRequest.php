<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BancoRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'numero' => 'required|unique:bancos',
            'descricao' => 'required|unique:bancos'

        ];
    }

    public function messages()
    {
        return [
            'numero.required' => 'Numero é obrigatorio',
            'numero.unique' => 'Numero ja existe (banco ja cadastrado)',
            'descricao.required' => 'Descricao é obrigatoria',
            'descricao.unique' => 'banco ja existe',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
