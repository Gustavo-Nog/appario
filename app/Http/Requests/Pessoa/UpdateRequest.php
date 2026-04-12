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

    public function prepareForValidation()
    {
        if ($this->has('cpf')) {
            $this->merge([
                'cpf' => preg_replace('/\D/', '', $this->cpf),
            ]);
        }
    }

        public function ufs(): array 
    {
        return [
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapá',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondônia',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SP' => 'São Paulo',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins',
        ];
    }

    public function rules(): array
    {
        $ufs = array_keys($this->ufs());

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

            'logradouro'  => 'sometimes|nullable|string|max:80',
            'numero'      => 'sometimes|nullable|string|max:10',
            'complemento' => 'nullable|string|max:75',
            'bairro'      => 'sometimes|nullable|string|max:50',
            'cep'         => 'sometimes|nullable|string|size:10',
            'cidade'      => 'sometimes|nullable|string|max:50',
            'estado'      => ['sometimes', 'nullable', 'string', 'size:2', Rule::in($ufs)],
        ];
    }
}
