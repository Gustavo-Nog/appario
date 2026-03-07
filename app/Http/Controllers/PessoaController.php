<?php

namespace App\Http\Controllers;

use App\Repositories\PessoaRepository;
use App\Http\Requests\Pessoa\StoreRequest;
use App\Http\Requests\Pessoa\UpdateRequest;
use Illuminate\Http\Request;

class PessoaController extends Controller
{   
    protected PessoaRepository $pessoaRepository;

    public function __construct(PessoaRepository $pessoaRepository) {
        $this->pessoaRepository = $pessoaRepository;
    }

    public function index(Request $request)
    {
        try {
            $pessoas = $this->pessoaRepository->getAllPessoas();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => $pessoas
                ], 200);
            }
            
            return view('pessoas.listar', compact('pessoas'));
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
                    'error' => 'Erro a listar as pessoas' . $th->getMessage()
                ]);
        }
    }

    public function show(int $id_pessoa, Request $request) 
    {
        try {
            $pessoa = $this->pessoaRepository->getPessoaById($id_pessoa);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => $pessoa
                ], 200);
            }

            return view('pessoas.show', compact('pessoa'));
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'   => 'failed',
                    'message'  => $th->getMessage()
                ], 404);
            }
        }
    }

    public function create(Request $request)
    {
        try {
            $usuario_id = session('usuario_id');

            if (!$usuario_id) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'É necessário cadastrar um usuário primeiro.'
                    ], 400);
                }

                return redirect()->route('usuarios.create')->with(
                    'error', 'É necessário cadastrar um usuário primeiro.'
                );
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data' => ['usuario_id' => $usuario_id]
                ], 200);
            }

            return view('pessoas.inserir', compact('usuario_id'));
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
        $request->merge([
            'usuario_id' => session('usuario_id')
        ]);

        $data = $request->validated();

        try {
            $pessoa = $this->pessoaRepository->createPessoa($data);

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => $pessoa
                ], 201);
            }

            session()->forget('usuario_id');
            return redirect()->route('home')->with('success', 'Cadastro concluído com sucesso!');
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => $th->getMessage()
                ], 400);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Erro ao criar o pessoa: ' . $th->getMessage()
                ]);
        }
    }


    public function edit(int $id_pessoa)
    {
        return view('pessoas.edit', compact('pessoa'));
    }

    public function update(UpdateRequest $request, int $id_pessoa)
    { 
        $data = $request->validated();
        try {
            $pessoa = $this->pessoaRepository->updatePessoa($id_pessoa, $data);

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => $pessoa
                ], 200);
            }
            
            return redirect()->route('pessoas.show', $pessoa->id_pessoa)
            ->with('success', 'Pessoa atualizada com sucesso!');
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => $th->getMessage()
                ], 400);
            }
            
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Erro ao atualizar o pessoa: ' . $th->getMessage()
                ]);
        }
    }

    public function delete(int $id_pessoa, Request $request)
    {
        return view('pessoas.destroy', compact('pessoa'));
    }

    public function destroy(int $id_pessoa, Request $request)
    {
        try {
            $this->pessoaRepository->deletePessoa($id_pessoa);
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Pessoa removida com sucesso.'
                ], 200);
            }

            return redirect()->route('usuarios.create')->with('success', 'Pessoa e usuário excluídos com sucesso!');
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Não foi possível remover a pessoa.'
                ], 404);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Não foi possível deletar a pessoa: ' . $th->getMessage()
                    ]);
        }
    }
}