<?php

namespace App\Repositories;

use App\Models\Colmeia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ColmeiaRepository
{
    protected Colmeia $colmeiaModel;

    public function __construct(Colmeia $colmeiaModel) {
        $this->colmeiaModel = $colmeiaModel;
    }

    public function getColmeiasByApiario(int $apiario_id): Collection
    {
        $colmeias = $this->colmeiaModel
            ->where('apiario_id', $apiario_id)
            ->oldest()
            ->get();
        return $colmeias;
    }

    public function getColmeiasByApiarios(array $apiarioIds): Collection
    {
        $colmeias = $this->colmeiaModel
            ->whereIn('apiario_id', $apiarioIds)
            ->get();
        return $colmeias;
    }

    public function findByIdApiario(int $id_colmeia, int $id_apiario): Colmeia
    {
        $colmeia = $this->colmeiaModel
            ->where('id_colmeia', $id_colmeia)
            ->where('apiario_id', $id_apiario)
            ->firstOrFail();
        return $colmeia;
    }

    public function createColmeia(int $id_apiario, array $data): Colmeia
    {
        $data['apiario_id'] = $id_apiario;
        $colmeia = $this->colmeiaModel->create($data);
        return $colmeia;
    }

    public function updateColmeia(int $id_colmeia, int $id_apiario, array $data): Colmeia
    {
        $colmeia = $this->findByIdApiario($id_colmeia, $id_apiario);
        $colmeia->update($data);
        return $colmeia;
    }

    public function deleteColmeia(int $id_colmeia, int $id_apiario): bool
    {
        $colmeia = $this->findByIdApiario($id_colmeia, $id_apiario);
        return (bool) $colmeia->delete();
    }
}