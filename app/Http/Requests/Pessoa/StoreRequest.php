<?php

namespace App\Http\Requests\Pessoa;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:50',
            'sobrenome' => 'required|string|max:50',
            'cpf' => 'required|string|size:11|unique:pessoas,cpf',
            'tipo_pessoa' => ['required', Rule::in(['APICULTOR', 'RESPONSAVEL'])],
            'usuario_id' => [
                'required',
                'exists:usuarios,id_usuario'
            ]
        ];
    }
}
