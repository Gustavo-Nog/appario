<?php

namespace App\Http\Requests\Apiario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function prepareForValidation()
    {
        if ($this->has('cep')) {
            $this->merge([
                'cep' => preg_replace('/\D/', '', $this->cep),
            ]);
        }
    }

    public function ufs(): array
    {
        return [
            'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas',
            'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo',
            'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná',
            'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina',
            'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins'
        ];
    }

    public function rules(): array
    {
        $ufs = array_keys($this->ufs());

        return [
            'nome' => 'sometimes|string|max:100',
            'area' => 'sometimes|numeric|max:50',
            'data_criacao' => 'sometimes|date',
            'coordenadas' => 'nullable|string|max:70',

            // ENDEREÇO
            'logradouro' => 'sometimes|string|max:80',
            'numero' => 'sometimes|string|max:10',
            'complemento' => 'nullable|string|max:75',
            'bairro' => 'sometimes|string|max:50',
            'cep' => 'sometimes|string|size:8',
            'cidade' => 'sometimes|string|max:50',
            'estado' => ['sometimes', 'string', 'size:2', Rule::in($ufs)],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.max' => 'O campo Nome não pode ter mais que :max caracteres.',
            'cep.size' => 'O campo CEP deve conter exatamente :size caracteres.',
            'estado.in' => 'O estado selecionado não é válido.',
        ];
    }


}
