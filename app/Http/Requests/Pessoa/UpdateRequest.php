<?php

namespace App\Http\Requests\Pessoa;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'sometimes|string|max:50',
            'sobrenome' => 'sometimes|string|max:50',
            'cpf' => [
                'sometimes',
                'string',
                'size:11',
                Rule::unique('pessoas', 'cpf')->ignore($this->route('pessoa'), 'id_pessoa')
            ],
            'tipo_pessoa' => ['sometimes', Rule::in(['APICULTOR', 'RESPONSAVEL'])],
            //'usuario_id' => 'sometimes|exists:usuarios,id_usuarios',
        ];
    }
}
