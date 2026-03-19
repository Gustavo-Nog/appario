<?php

namespace App\Http\Requests\EnderecoApiario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $ufs = [
            'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES',
            'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR',
            'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC',
            'SP', 'SE', 'TO'
        ];

        return [
            'logradouro' => 'sometimes|string|max:80',
            'numero' => 'sometimes|string|max:10',
            'complemento' => 'nullable|string|max:75',
            'bairro' => 'sometimes|string|max:50',
            'cep' => 'sometimes|string|size:10',
            'cidade' => 'sometimes|string|max:50',
            'estado' => ['sometimes', 'string', 'size:2', Rule::in($ufs)],
        ];
    }

    public function messages(): array
    {
        return [
            'cep.size' => 'O CEP deve conter exatamente 10 caracteres.',
            'estado.in' => 'Selecione um estado válido.',
            'numero.max' => 'Número excede o tamanho máximo de :max caracteres.',
        ];
    }
}
