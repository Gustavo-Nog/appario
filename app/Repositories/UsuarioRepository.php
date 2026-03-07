<?php

namespace App\Repositories;

use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class UsuarioRepository 
{
    protected Usuario $usuarioModel;

    public function __construct(Usuario $usuarioModel) {
        $this->usuarioModel = $usuarioModel;
    }

    public function getAllUsuarios() 
    {
        $usuarios = $this->usuarioModel
            ->oldest()
            ->get(['id_usuario', 'email', 'tipo_usuario']);

        return $usuarios;
    }

    public function getUsuarioById(int $id_usuario): Usuario
    {   
        $usuario = $this->usuarioModel
            ->with(['pessoa'])
            ->findOrFail($id_usuario);
        return $usuario;
    }

    public function createUsuario(array $data) 
    {
        DB::beginTransaction();

        try {
            $usuario = $this->usuarioModel->create($data);
            $usuario->pessoa()->create($data);

            DB::commit();
            $usuario = $usuario->load('pessoa');

            return $usuario;
        } catch (\Throwable $th) {
            DB::rollBack(); 
            throw $th; 
        } 
    }

    public function updateUsuario(int $id_usuario, array $data)
    {
        DB::beginTransaction();

        try {
            $usuario = $this->getUsuarioById($id_usuario);
            $usuario->update($data);
            $usuario->pessoa->update($data);

            DB::commit();
            $usuario->refresh()->load('pessoa');

            return $usuario;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function deleteUsuario(int $id_usuario)
    {
        $usuario = $this->getUsuarioById($id_usuario);
        return (bool) $usuario->delete();
    }
}