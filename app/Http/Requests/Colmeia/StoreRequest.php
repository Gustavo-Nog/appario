<?php

namespace App\Http\Requests\Colmeia;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        // Permite só usuários logados atualizarem
        return auth()->check();
    }

    public function rules()
    {
        return [
            'especie' => ['required', 'string', 'max:50'],
            'tamanho' => ['required', 'string', 'max:35'],
            'data_aquisicao' => ['required', 'date'],
            'apiario_id' => ['required', 'integer', 'exists:apiarios,id_apiario'],
        ];
    }

    public function messages()
    {
        return [
            'especie.required' => 'O campo espécie é obrigatório.',
            'especie.string' => 'O campo espécie deve ser uma string.',
            'especie.max' => 'O campo espécie deve ter no máximo 50 caracteres.',

            'tamanho.required' => 'O campo tamanho é obrigatório.',
            'tamanho.string' => 'O campo tamanho deve ser uma string.',
            'tamanho.max' => 'O campo tamanho deve ter no máximo 35 caracteres.',

            'data_aquisicao.required' => 'O campo data de aquisição é obrigatório.',
            'data_aquisicao.date' => 'O campo data de aquisição deve ser uma data válida.',

            'apiario_id.required' => 'O campo apiário é obrigatório.',
            'apiario_id.integer' => 'O campo apiário deve ser um número inteiro.',
            'apiario_id.exists' => 'O apiário selecionado não existe.',
        ];
    }
}
