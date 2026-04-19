<?php

namespace App\Http\Controllers;

use App\Repositories\PessoaRepository;
use App\Repositories\ApiarioRepository;
use App\Http\Requests\Pessoa\StoreRequest;
use App\Http\Requests\Pessoa\UpdateRequest;
use Illuminate\Http\Request;

class PessoaController extends Controller
{   
    protected PessoaRepository $pessoaRepository;
    protected ApiarioRepository $apiarioRepository;

    public function __construct(PessoaRepository $pessoaRepository, ApiarioRepository $apiarioRepository) {
        $this->pessoaRepository = $pessoaRepository;
        $this->apiarioRepository = $apiarioRepository;
    }

    public function index(Request $request)
    {
        $pessoa = $request->attributes->get('pessoa');
        $tipo_pessoa = $this->pessoaRepository->getPessoaResponsavel($pessoa->id_pessoa);
        $is_admin = $tipo_pessoa === 'RESPONSAVEL' ? true : false;

         if ($is_admin) {
            try {
                $pessoas = $this->pessoaRepository->getAllPessoasTotalColmeias();
                if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'success',
                        'pessoas'   => $pessoas,
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
         } else {
            return redirect()->route('login.form');
         }
    }

    public function show(Request $request) 
    {
        $pessoa = $request->attributes->get('pessoa');
        $id_pessoa = $pessoa->id_pessoa;

        try {
            $apiarios = $this->apiarioRepository->getApiarioByPessoa($id_pessoa);
            $totalColmeias = $this->apiarioRepository->getTotalColmeias($id_pessoa);
            $endereco = $pessoa->getEnderecoPrincipal();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => [ 
                        'pessoa' => $pessoa,
                        'apiarios' => $apiarios,
                        'enderecos' => $endereco,
                        'totalColmeias' => $totalColmeias
                    ]
                ], 200);
            }

            return view('pessoas.show', compact('pessoa', 'apiarios', 'endereco', 'totalColmeias'));
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
            return redirect()->route('login.form')->with('success', 'Cadastro concluído com sucesso!');
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


    public function edit(int $id_pessoa, UpdateRequest $request)
    {
        $pessoa = request()->attributes->get('pessoa');
        $endereco = $pessoa->getEnderecoPrincipal();
        $ufs = $request->ufs();
        return view('pessoas.edit', compact('pessoa', 'endereco', 'ufs'));
    }

    public function update(UpdateRequest $request, int $id_pessoa)
    { 
        $data = $request->validated();
        try {
            $pessoa = $this->pessoaRepository->updatePessoa($id_pessoa, $data);
            $id_pessoa = $pessoa->id_pessoa;

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => $pessoa
                ], 200);
            }
            
            return redirect()->route('pessoas.show', $id_pessoa)
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
        $pessoa = $request->attributes->get('pessoa');
        return view('pessoas.destroy', compact('pessoa'));
    }

    public function destroy(int $id_pessoa, Request $request)
    {
        $pessoa = $request->attributes->get('pessoa');
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