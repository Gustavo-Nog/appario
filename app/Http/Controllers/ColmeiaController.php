<?php

namespace App\Http\Controllers;

use App\Repositories\ColmeiaRepository;
use App\Repositories\ApiarioRepository;
use App\Services\RelatorioService; 
use Illuminate\Http\Request;
use App\Http\Requests\Colmeia\StoreRequest;
use App\Http\Requests\Colmeia\UpdateRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ColmeiaController extends Controller
{
    use AuthorizesRequests;
    protected ColmeiaRepository $colmeiaRepository;
    protected ApiarioRepository $apiarioRepository;
    protected RelatorioService $colmeiaRelatorio;

    public function __construct(ColmeiaRepository $colmeiaRepository, ApiarioRepository $apiarioRepository, RelatorioService $colmeiaRelatorio) {
        $this->colmeiaRepository = $colmeiaRepository;
        $this->colmeiaRelatorio = $colmeiaRelatorio;
        $this->apiarioRepository = $apiarioRepository;
    }
    
    public function index(Request $request): JsonResponse|View|RedirectResponse
    {
        try {
            $pessoa = $request->attributes->get('pessoa');
            $this->authorize('viewAny', Colmeia::class);
            $pessoa_id = $pessoa->id_pessoa;
            $apiarios = $this->apiarioRepository->getApiarioByPessoa($pessoa_id);
            $ids_apiarios = $apiarios->pluck('id_apiario')->toArray();
            $colmeias = $this->colmeiaRepository->getColmeiasByApiarios($ids_apiarios);

            if ($request->wantsJson()) {
                    return response()->json([
                    'status' => 'success',
                    'data'   => $colmeias
                ], 200);
            }
            

            return view('colmeias.index', compact('colmeias'));
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => $th->getMessage()
                ], 500);
            }

            return redirect()->route('dashboard')
                ->with('error', 'Pessoa não encontrada para este usuário.');
        }
    }

    public function show(int $id_apiario, int $id_colmeia, Request $request): JsonResponse|View
    {
        $pessoa = $request->attributes->get('pessoa');
        $id_pessoa = $pessoa->id_pessoa;

        try {
            $this->apiarioRepository->findForPessoaOrFail($id_apiario, $id_pessoa);
            $colmeia = $this->colmeiaRepository->findByIdApiario($id_colmeia, $id_apiario);

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $colmeia
                ], 200);
            }

            return view('colmeias.show', compact('colmeia'));
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Acesso negado ou registro não encontrado.'
            ], 403);
        }
    }

    public function create(Request $request): View
    {
        $pessoa = $request->attributes->get('pessoa');
        $id_pessoa = $pessoa->id_pessoa;
        $apiarios = $this->apiarioRepository->getApiarioByPessoa($id_pessoa);

        return view('colmeias.create', compact('apiarios'));
    }

    public function store(StoreRequest $request): JsonResponse|RedirectResponse
    {
        $pessoa = $request->attributes->get('pessoa');
        $pessoa_id = $pessoa->id_pessoa;
        $data = $request->validated();
        $id_apiario = $data['apiario_id'];

        try {
            $this->apiarioRepository->findForPessoaOrFail($id_apiario, $pessoa_id);
            $colmeia = $this->colmeiaRepository->createColmeia($id_apiario, $data);

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => $colmeia
                ], 201);
            }

            return redirect()->route('colmeias.index')
                ->with('success', 'Colmeia criada com sucesso!');

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
                    'error' => 'Erro ao criar colmeia: ' . $th->getMessage()
                ]);
        }
    }

    public function edit(int $id_apiario, int $id_colmeia, Request $request): View
    {
        $pessoa = $request->attributes->get('pessoa');
        $id_pessoa = $pessoa->id_pessoa;
        $apiarios = $this->apiarioRepository->getApiarioByPessoa($id_pessoa);

        $colmeia = $this->colmeiaRepository->findByIdApiario($id_colmeia, $id_apiario);
        $this->authorize('update', $colmeia);

        return view('colmeias.editar', compact('colmeia', 'apiarios'));
    }

    public function update(int $id_apiario, int $id_colmeia, UpdateRequest $request): JsonResponse|RedirectResponse
    {
        $pessoa = $request->attributes->get('pessoa');
        $id_pessoa = $pessoa->id_pessoa;

        try {
            $this->apiarioRepository->findForPessoaOrFail($id_apiario, $id_pessoa);
            $data = $request->validated();
            $colmeia = $this->colmeiaRepository->updateColmeia(
                $id_colmeia,
                $id_apiario,
                $data
            );

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => $colmeia
                ], 201);
            }

            return redirect()->route('colmeias.index')
                ->with('success', 'Colmeia atualizada com sucesso!');
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => $th->getMessage()
                ], 404 );
            }

            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Erro ao atualizar a colmeia: ' . $th->getMessage()
                ]);
        }
    }

    public function destroy(int $id_apiario, int $id_colmeia, Request $request): JsonResponse|RedirectResponse
    {
        $pessoa = $request->attributes->get('pessoa');
        $id_pessoa = $pessoa->id_pessoa;
        $this->apiarioRepository->findForPessoaOrFail($id_apiario, $id_pessoa);

        try {
            $this->colmeiaRepository->deleteColmeia($id_colmeia, $id_apiario);

            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Colmeia removido com sucesso.'
                ], 202);
            }

            return redirect()->route('colmeias.index')
                ->with('success', 'Colmeia removida com sucesso.');
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Não foi possivel remover a colmeia.'
                ], 400);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Erro ao Deletar a colmeia: ' . $th->getMessage()
                ]);
        }
    }

    public function gerarRelatorioPDF(Request $request) 
    {
        $pessoa = $request->attributes->get('pessoa');
        $id_pessoa = $pessoa->id_pessoa;
        $format = $request->wantsJson() ? 'json' : 'pdf';

        try {
            $relatorio = $this->colmeiaRelatorio->colmeiaRelatorioPDF($id_pessoa, $format);
            
            return $relatorio->download('relatorio-colmeias.pdf');
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Erro ao gerar relatório.'
                ], 500);
            }

            return redirect()->back()->withErrors([
                'error' => 'Erro ao gerar o relatório: ' . $th->getMessage()
            ]);
        }
    }
}