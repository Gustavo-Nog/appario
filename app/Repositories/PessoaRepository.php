<?php 

namespace App\Repositories;

use App\Models\Pessoa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

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

    public function getEnderecosByPessoa(int $id_pessoa)
    {
        $pessoa = $this->getPessoaById($id_pessoa);
        return $pessoa->enderecos()->get();
    }

    public function createPessoa(array $data)
    {
        $pessoa = $this->pessoaModel->create($data); // Já pega os valores do $fillable
        return $pessoa;
    }

    public function updatePessoa(int $id_pessoa, array $data): Pessoa
    {
        DB::beginTransaction();
        try {
            $pessoa = $this->getPessoaById($id_pessoa);
            $pessoa->update($data);
            $enderecoData = Arr::only($data, [
                'logradouro',
                'numero',
                'complemento',
                'bairro',
                'cep',
                'cidade',
                'estado',
            ]);

            $pessoa->enderecos()->updateOrCreate(
                ['pessoa_id' => $id_pessoa],
                $enderecoData
            );
            DB::commit();
            $pessoa->refresh()->load('enderecos');
            return $pessoa;

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function deletePessoa(int $id_pessoa)
    {
        $pessoa = $this->getPessoaById($id_pessoa);
        return (bool) $pessoa->delete();
    }
}