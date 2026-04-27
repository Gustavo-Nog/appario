<?php

namespace App\Http\Controllers;

use App\Repositories\UsuarioRepository ;
use App\Http\Requests\Usuario\StoreRequest;
use App\Http\Requests\Usuario\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    protected UsuarioRepository $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository) {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function index(Request $request)
    {
        try {
            $usuarios = $this->usuarioRepository->getAllUsuarios();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => $usuarios
                ], 200);
            }

            return view('usuarios.listar', compact('usuarios'));

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function create(Request $request)
    {
        try {
            $origem = $request->query('origem');
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => []
                ], 200);
            }

            return view('usuarios.create', compact('origem'));
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => $th->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Erro ao carregar formulário de criação: ' . $th->getMessage()
                ]);
        }
    }


    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        try {
            $usuario = $this->usuarioRepository->createUsuario($data);
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => $usuario
                ], 201);
            }

            if ($request->input('origem') === 'listar') {
                return redirect()->route('pessoas.listar')->with('success', 'Usuário e pessoa cadastrados com sucesso!');
            }

            return redirect()->route('dashboard')->with('success', 'Usuário e pessoa cadastrados com sucesso!');

        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'failed',
                    'message' =>  $th->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Erro ao criar usuário: ' . $th->getMessage()
                ]);
        }
    }

    public function show(int $id_usuario, Request $request)
    {
        try {
            $usuario = $this->usuarioRepository->getUsuarioById($id_usuario);
        
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => $usuario
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Usuário não encontrado em nossa base de dados.'
            ], 404);
        
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'   => 'error',
                    'message'  => $th->getMessage()
                ], 404);
            }
        }
    }

    public function edit(Usuario $usuario)
    {
        
    }

    public function update(UpdateRequest $request, int $id_usuario)
    {
        $data = $request->validated();
        try {
            $usuario = $this->usuarioRepository->updateUsuario($id_usuario, $data);

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => $usuario
                ], 200);
            }

        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => $th->getMessage()
                ], 400);
            }
        }
    }

    public function destroy(int $id_usuario, Request $request)
    {
        try {
            $this->usuarioRepository->deleteUsuario($id_usuario);

            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Usuário deletado com sucesso'
                ], 200);
            }
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Erro ao deletar usuário: ' . $th->getmessage()
                ], 404);
            }
        }
    }
}
