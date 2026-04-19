<?php 

namespace App\Repositories;

use App\Models\Pessoa;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class PessoaRepository
{
    protected Pessoa $pessoaModel;

    public function __construct(Pessoa $pessoaModel) {
        $this->pessoaModel = $pessoaModel;
    }

    public function getPessoaById(int $id_pessoa): Pessoa
    {
        $pessoa = $this->pessoaModel->findOrFail($id_pessoa);
        return $pessoa;
    }

    public function getPessoaResponsavel(int $id_pessoa): ?string
    {
        $pessoa = $this->getPessoaById($id_pessoa);
        return $pessoa->tipo_pessoa;
    }

    public function getAllPessoasTotalColmeias(): Collection
    {
        return $this->pessoaModel
            ->select('id_pessoa', 'nome', 'sobrenome', 'cpf', 'tipo_pessoa')
            ->withCount('colmeias')
            ->oldest()
            ->get();
    }

    public function getEnderecosByPessoa(int $id_pessoa)
    {
        $pessoa = $this->getPessoaById($id_pessoa);
        return $pessoa->enderecos()->get();
    }

    public function createPessoa(array $data): Pessoa
    {
        $pessoa = $this->pessoaModel->create($data);
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

    public function deletePessoa(int $id_pessoa): bool
    {
        $pessoa = $this->getPessoaById($id_pessoa);
        return (bool) $pessoa->delete();
    }
}