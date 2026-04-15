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

    public function prepareForValidation()
    {
        if ($this->has('cpf')) {
            $this->merge([
                'cpf' => preg_replace('/\D/', '', $this->cpf),
            ]);
        }

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
            'nome'        => 'required|string|max:50',
            'sobrenome'   => 'required|string|max:50',
            'cpf'         => 'nullable|string|size:11|unique:pessoas,cpf',
            'tipo_pessoa' => ['required', Rule::in(['APICULTOR', 'RESPONSAVEL'])],
            /*'usuario_id' => [
                'required',
                'exists:usuarios,id_usuario'
            ], */

            'logradouro'  => 'sometimes|nullable|string|max:80',
            'numero'      => 'sometimes|nullable|string|max:10',
            'complemento' => 'nullable|string|max:75',
            'bairro'      => 'sometimes|nullable|string|max:50',
            'cep'         => 'sometimes|nullable|string|size:8',
            'cidade'      => 'sometimes|nullable|string|max:50',
            'estado'      => ['sometimes', 'nullable', 'string', 'size:2', Rule::in($ufs)],
        ];
    }
}
