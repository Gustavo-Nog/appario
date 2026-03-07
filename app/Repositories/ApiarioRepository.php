<?php

namespace App\Repositories;

use App\Models\Apiario;
use App\Models\EnderecoApiario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class ApiarioRepository 
{
    protected Apiario $apiarioModel;

    public function __construct(Apiario $apiarioModel)
    {
        $this->apiarioModel = $apiarioModel;
    }

    public function getApiarioByPessoa(int $pessoa_id)
    {
        return $this->apiarioModel
            ->with('enderecos', 'colmeias')
            ->withCount('colmeias')
            ->where('pessoa_id', $pessoa_id)
            ->oldest()
            ->get();
    }

    public function findForPessoaOrFail(int $id_apiario, int $pessoa_id)
    {
        return $this->apiarioModel
            ->where('id_apiario', $id_apiario)
            ->where('pessoa_id', $pessoa_id)
            ->with('enderecos')
            ->firstOrFail();
    }

    public function getApiarioById(int $id_apiario): Apiario
    {
        $apiario = $this->apiarioModel
            ->with(['enderecos', 'pessoa'])
            ->findOrFail($id_apiario);
        return $apiario;
    }

    public function createApiario(array $data) 
    {
        DB::beginTransaction();
        try {
            $apiario = $this->apiarioModel->create([
                'nome'         => $data['nome'],
                'area'         => $data['area'],
                'coordenadas'  => $data['coordenadas'] ?? null,
                'data_criacao' => $data['data_criacao'],
                'pessoa_id'    => $data['pessoa_id'],
            ]);

            $apiario->enderecos()->create([
                'logradouro'  => $data['logradouro'],
                'numero'      => $data['numero'],
                'complemento' => $data['complemento'] ?? null,
                'bairro'      => $data['bairro'],
                'cep'         => $data['cep'],
                'cidade'      => $data['cidade'],
                'estado'      => $data['estado']
            ]);

            DB::commit();
            $apiario = $apiario->load('enderecos');
            return $apiario;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function updateApiario(int $id_apiario, int $pessoa_id, array $data): Apiario
    {
        DB::beginTransaction();

        try {
            $apiario = $this->findForPessoaOrFail($id_apiario, $pessoa_id);
            $apiario->update($data);

            $enderecoData = Arr::only($data, [
                'logradouro',
                'numero',
                'complemento',
                'bairro',
                'cep',
                'cidade',
                'estado',
            ]);

            $apiario->enderecos()->updateOrCreate(
                ['apiario_id' => $id_apiario],
                $enderecoData
            );

            DB::commit();
            $apiario->refresh()->load('enderecos');
            return $apiario;
  
        } catch (\Throwable $th) {
            DB::rollBack(); 
            throw $th;  
        }
    }

    public function deleteApiario(int $id_apiario, int $pessoa_id) 
    {
        $apiario = $this->findForPessoaOrFail($id_apiario, $pessoa_id);
        return (bool) $apiario->delete();
    }
}