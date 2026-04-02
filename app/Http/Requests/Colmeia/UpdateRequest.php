<?php

namespace App\Http\Requests\Colmeia;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'especie' => 'sometimes|string|max:50',
            'tamanho' => 'sometimes|string|max:35',
            'data_aquisicao' => 'sometimes|date',
            'apiario_id' => 'sometimes|integer|exists:apiarios,id_apiario',
        ];
    }

    public function messages()
    {
        return [
            'especie.max' => 'O campo espécie deve ter no máximo :max caracteres.',
            'data_aquisicao.date' => 'O campo data de aquisição deve ser uma data válida.',
            'apiario_id.required' => 'O campo apiário é obrigatório.',
            'apiario_id.exists' => 'O apiário selecionado não existe.',
        ];
    }
}
