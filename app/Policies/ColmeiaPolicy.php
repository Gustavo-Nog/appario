<?php

namespace App\Policies;

use App\Models\Colmeia;
use App\Models\Usuario;

class ColmeiaPolicy
{
    public function viewAny(Usuario $usuario): bool
    {
        return $usuario->pessoa !== null;
    }

    public function view(Usuario $usuario, Colmeia $colmeia): bool
    {
        return $usuario>pessoa && $colmeia->apiario->pessoa_id === $usuario->pessoa->id_pessoa;
    }

    public function create(Usuario $usuario): bool
    {
        return $usuario->pessoa !== null;
    }

    public function update(Usuario $usuario, Colmeia $colmeia): bool
    {
        return $usuario->pessoa && $colmeia->apiario->pessoa_id === $usuario->pessoa->id_pessoa;
    }

    public function delete(Usuario $usuario, Colmeia $colmeia): bool
    {
        return $usuario->pessoa && $colmeia->apiario->pessoa_id === $usuario->pessoa->id_pessoa;
    }
}
