<?php

namespace App\Http\Controllers;

use App\Models\Apiario;
use App\Repositories\ApiarioRepository;
use App\Services\RelatorioService;
use App\Http\Requests\Apiario\StoreRequest;
use App\Http\Requests\Apiario\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ApiarioController extends Controller
{
    use AuthorizesRequests;
    protected ApiarioRepository $apiarioRepository;
    protected RelatorioService $apiarioRelatorio;

    public function __construct(ApiarioRepository $apiarioRepository, RelatorioService $apiarioRelatorio) {
        $this->apiarioRepository = $apiarioRepository;
        $this->apiarioRelatorio = $apiarioRelatorio;
    }

    public function index(Request $request): JsonResponse|View
    {
        try {
            $pessoa = $request->attributes->get('pessoa');
            $this->authorize('viewAny', Apiario::class);
            $id_pessoa = $pessoa->id_pessoa;
            $apiarios = $this->apiarioRepository->getApiarioByPessoa($id_pessoa);

            if ($request->wantsJson()) {
                    return response()->json([
                    'status' => 'success',
                    'data'   => $apiarios
                ], 200);
            }

            return view('apiarios.listar', compact('apiarios'));

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    public function create(): View
    {
        $ufs = (new StoreRequest())->ufs();
        return view('apiarios.adicionar', compact('ufs'));
    }

    public function store(StoreRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Apiario::class);

        $pessoa = $request->attributes->get('pessoa');
        $data = $request->validated();
        $data['pessoa_id'] = $pessoa->id_pessoa;

        try {
            $apiario = $this->apiarioRepository->createApiario($data);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => $apiario
                ], 201);
            }

            return redirect()->route('apiarios.index')
                ->with('success', 'Apiário e endereço criados com sucesso!');

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
                    'error' => 'Erro ao criar o apiário: ' . $th->getMessage()
                ]);
        }
    }

    public function show(int $id_apiario, Request $request): JsonResponse|View|RedirectResponse
    {
        $pessoa = $request->attributes->get('pessoa');
        $id_pessoa = $pessoa->id_pessoa;

        try {
            $apiario = $this->apiarioRepository->findForPessoaOrFail($id_apiario, $id_pessoa);
            $endereco = $apiario->enderecos;
            $ufs = $endereco ? array_merge(
                $endereco->toArray(),
                ['estado_nome' => $endereco->estado_nome]
            ) : [];
            $this->authorize('view', $apiario);

            if ($request->wantsJson()) {
                return response()->json([
                    'status'   => 'success',
                    'apiario'  => $apiario,
                    'endereco' => $endereco,
                    'ufs'      => $ufs
                ], 200);
            }

            return view('apiarios.mostrar', compact('apiario', 'endereco', 'ufs'));
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'failed',
                    'message'   => $th->getMessage()
                ], 403);
            }

            return redirect()->back()
                ->withError(['error' => 'Não foi possivel acessar as informações desse apiário: ' . $th->getMessage()]);
        }

    }

    public function edit(int $id_apiario, UpdateRequest $request): View
    {
        $pessoa = $request->attributes->get('pessoa');
        $id_pessoa = $pessoa->id_pessoa;
        $apiario = $this->apiarioRepository->findForPessoaOrFail($id_apiario, $id_pessoa);
        
        $this->authorize('update', $apiario);
        $ufs = $request->ufs();
        $endereco = $apiario->enderecos;

        return view('apiarios.editar', compact('apiario', 'endereco', 'ufs'));
    }

    public function update(int $id_apiario, UpdateRequest $request): JsonResponse|RedirectResponse
    {
        $pessoa = $request->attributes->get('pessoa');
        $id_pessoa = $pessoa->id_pessoa;

        $data = $request->validated();

        try {
            // $apiario = $this->apiarioRepository->findForPessoaOrFail($id_apiario, $pessoa->id_pessoa);
            // $this->authorize('update', $apiario);
            $apiario = $this->apiarioRepository->updateApiario($id_apiario, $id_pessoa, $data);

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data'   => $apiario
                ], 200);
            }

            return redirect()
                ->route('apiarios.index')
                ->with('success', 'Apiário e endereço atualizados com sucesso!');

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
                    'error' => 'Erro ao atualizar o apiário: ' . $th->getMessage()
                ]);
        }
    }

    public function destroy(int $id_apiario, Request $request): JsonResponse|RedirectResponse
    {
        $pessoa = $request->attributes->get('pessoa');
        $id_pessoa = $pessoa->id_pessoa;
        try {
            $apiario = $this->apiarioRepository->findForPessoaOrFail($id_apiario, $id_pessoa);
            $this->authorize('delete', $apiario);
            $this->apiarioRepository->deleteApiario($id_apiario, $id_pessoa);

            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Apiário removido com sucesso.'
                ], 204);
            }

            return redirect()->route('apiarios.index')
            ->with('success',  'Apiário removido com sucesso.');
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Não foi possivel remover o apiário.'
                ], 400);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Erro ao Deletar o apiário: ' . $th->getMessage()
                ]);
        }
    }

    public function gerarRelatorioPDF(Request $request)
    {   
        $pessoa = $request->attributes->get('pessoa');
        $id_pessoa = $pessoa->id_pessoa;
        $format = $request->wantsJson() ? 'json' : 'pdf';

        try {
            $relatorio = $this->apiarioRelatorio->apiarioRelatorioPDF($id_pessoa, $format);

            return $relatorio->download('relatorio-apiarios.pdf');
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