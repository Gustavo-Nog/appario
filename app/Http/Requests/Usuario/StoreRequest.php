<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;    
            // Retorna um booleano para indicar se o usuário tem permissão para executar a ação solicitada.
    }

    public function rules(): array
    {
        // Rules: retorna regras de validação para os dados da solicitação.
        return [
            // CAMPOS DE USUARIO
            'email' => 'required|email|max:255|unique:usuarios,email',
                // email – O dado no campo deve ser um endereço de e-mail válido.
                // unique – Os dados no campo não podem ter duplicatas na tabela do banco de dados.
            'password' => 'required|string|min:8|confirmed', 
                // A regra 'confirmed' permite que você exija um determinado campo duas vezes para verificar se os dados são precisos
            'tipo_usuario' => ['nullable', Rule::in(['ADMIN', 'PESSOA'])],

             // Campos da pessoa
            'nome' => 'required|string|max:50',
            'sobrenome' => 'required|string|max:50',
            'cpf' => 'required|string|size:11|unique:pessoas,cpf',
            'tipo_pessoa' => ['nullable', Rule::in(['APICULTOR', 'RESPONSAVEL'])],
        ];
    }
    
    public function messages(): array
    {
        return [
            // Mensagens genéricas
            'required' => 'O campo :attribute é obrigatório.',
            'email' => 'O campo :attribute deve ser um e-mail válido.',
            'max' => 'O campo :attribute não pode ter mais que :max caracteres.',
            'min' => 'O campo :attribute deve ter pelo menos :min caracteres.',
            'confirmed' => 'A confirmação da senha não coincide.',
            'unique' => 'Este :attribute já está em uso.',
            'in' => 'O valor selecionado para :attribute é inválido.',
            'size' => 'O campo :attribute deve ter exatamente :size caracteres.',

            // Mensagens específicas por campo
            'password.confirmed' => 'As senhas não coincidem.',
            'cpf.size' => 'O CPF deve ter 11 dígitos.',
        ];
    }
}
