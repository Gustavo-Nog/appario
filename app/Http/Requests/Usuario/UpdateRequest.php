<?php

namespace App\Http\Requests\Usuario;

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
            'email' => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('usuarios', 'email')->ignore($this->route('usuario'), 'id_usuarios')
            ],
            'senha' => 'sometimes|string|min:8|confirmed',
            'tipo_usuario' => ['sometimes', Rule::in(['ADMIN', 'PESSOA'])],
        ];
    }
}
