<?php

namespace App\Services;

use App\Repositories\PessoaRepository;
use App\Repositories\ApiarioRepository;
use App\Repositories\ColmeiaRepository;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioService {
    
    protected PessoaRepository  $pessoaRepository;
    protected ApiarioRepository $apiarioRepository;
    protected ColmeiaRepository $colmeiaRepository;

    public function __construct(PessoaRepository $pessoaRepository, ApiarioRepository $apiarioRepository, ColmeiaRepository $colmeiaRepository) {
        $this->pessoaRepository = $pessoaRepository;
        $this->apiarioRepository = $apiarioRepository;
        $this->colmeiaRepository = $colmeiaRepository;
    }

    public function apiarioRelatorioPDF(int $pessoa_id, string $format = 'pdf') 
    {
        $pessoa = $this->pessoaRepository->getPessoaById($pessoa_id);
        $apiarios = $this->apiarioRepository->getApiarioByPessoa($pessoa_id);
        
        if ($format === 'json') {
            return response()->json([
                'status' => 'success',
                'data'   => [
                    'apiarios' => $apiarios,
                    'pessoa' => $pessoa
                ]
            ], 200);
        }

        $pdf = Pdf::loadView('relatorios.apiarios', compact('apiarios', 'pessoa'));
        return $pdf;
    }

    public function colmeiaRelatorioPDF(int $id_pessoa, string $format = 'pdf') 
    {
        $pessoa = $this->pessoaRepository->getPessoaById($id_pessoa);
        $apiarios = $this->apiarioRepository->getApiarioByPessoa($id_pessoa);
        $totalColmeias = $apiarios->sum('colmeias_count');
        $id_apiarios = $apiarios->pluck('id_apiario')->toArray();
        $colmeias = $this->colmeiaRepository->getColmeiasByApiarios($id_apiarios);
        
        if ($format === 'json') {
            return response()->json([
                'status' => 'success',
                'data'   => [
                    'colmeias' => $colmeias,
                    'pessoa' => $pessoa,
                    'totalColmeias' => $totalColmeias
                ]
            ], 200);
        }

        $pdf = Pdf::loadView('relatorios.colmeias', compact('colmeias', 'pessoa', 'totalColmeias'));
        return $pdf;
    }
}