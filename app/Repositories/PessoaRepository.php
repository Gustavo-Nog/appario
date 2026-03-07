<?php 

namespace App\Repositories;

use App\Models\Pessoa;

class PessoaRepository
{
    protected Pessoa $pessoaModel;

    public function __construct(Pessoa $pessoaModel) {
        $this->pessoaModel = $pessoaModel;
    }

    public function getAllPessoas()
    {
        $pessoas = $this->pessoaModel
            ->oldest()
            ->get(['id_pessoa', 'nome', 'sobrenome', 'tipo_pessoa']);
        return $pessoas;
    }

    public function getPessoaById(int $id_pessoa)
    {
        $pessoa = $this->pessoaModel->findOrFail($id_pessoa);
        return $pessoa;
    }

    public function createPessoa(array $data)
    {
        $pessoa = $this->pessoaModel->create($data); // Já pega os valores do $fillable
        return $pessoa;
    }

    public function updatePessoa(int $id_pessoa, array $data): Pessoa
    {
        $pessoa = $this->getPessoaById($id_pessoa);
        $pessoa->update($data);
        return $pessoa;
    }

    public function deletePessoa(int $id_pessoa)
    {
        $pessoa = $this->getPessoaById($id_pessoa);
        return (bool) $pessoa->delete();
    }
}