<?php

namespace App\Http\Requests\Apiario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            // Validação do Apiário
            'nome' => 'required|string|max:100',
            'area' => 'required|numeric|max:50',
            'data_criacao' => 'required|date',
            'coordenadas' => 'nullable|string|max:70',

            // Validação do Endereço
            'logradouro' => 'required|string|max:80',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:75',
            'bairro' => 'required|string|max:50',
            'cep' => 'required|string|size:8',
            'cidade' => 'required|string|max:50',
            'estado' => ['required', 'string', 'size:2', Rule::in($ufs)],
        ];
    }

    public function messages(): array
    {
        return [
            // Campos do apiário
            'nome.required' => 'O campo Nome é obrigatório.',
            'area.required' => 'O campo Área é obrigatório.',
            'data_criacao.required' => 'O campo Data de Criação é obrigatório.',

            // Campos do endereço
            'logradouro.required' => 'O campo Logradouro é obrigatório.',
            'numero.required' => 'O campo Número é obrigatório.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'cep.size' => 'O campo CEP deve ter exatamente 8 caracteres.',
            'estado.required' => 'O campo Estado é obrigatório.',
            'estado.in' => 'Selecione um estado válido.',
        ];
    }
}