<?php

namespace App\Policies;

use App\Models\Apiario;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;

class ApiarioPolicy
{
   
    public function viewAny(Usuario $usuario): bool
    {
        // Permitir visualizar lista apenas se o usuário tiver uma pessoa vinculada
        return $usuario->pessoa !== null;
    }

    public function view(Usuario $usuario, Apiario $apiario): bool
    {
        return $usuario->pessoa &&
           $apiario->pessoa_id === $usuario->pessoa->id_pessoa;
    }

    public function create(Usuario $usuario): Response
    {
        if ($usuario->pessoa) {
            return Response::allow();
        }

        return Response::deny('Usuário não está vinculado a uma pessoa.');
    }

    public function update(Usuario $usuario, Apiario $apiario): bool
    {
        return $usuario->pessoa &&
           $apiario->pessoa_id === $usuario->pessoa->id_pessoa;
    }

    public function delete(Usuario $usuario, Apiario $apiario): bool
    {
        return $usuario->pessoa &&
           $apiario->pessoa_id === $usuario->pessoa->id_pessoa; 
    }

    public function restore(Usuario $usuario, Apiario $apiario): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Usuario $usuario, Apiario $apiario): bool
    {
        return false;
    }
}
