<?php

namespace App\Services;

use App\Repositories\ApiarioRepository;
use App\Repositories\ColmeiaRepository;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioService {
    
    protected ApiarioRepository $apiarioRepository;
    protected ColmeiaRepository $colmeiaRepository;

    public function __construct(ApiarioRepository $apiarioRepository, ColmeiaRepository $colmeiaRepository) {
        $this->apiarioRepository = $apiarioRepository;
        $this->colmeiaRepository = $colmeiaRepository;
    }

    public function apiarioRelatorioPDF(int $pessoa_id, string $format = 'pdf') 
    {
        $apiarios = $this->apiarioRepository->getApiarioByPessoa($pessoa_id);
        
        if ($format === 'json') {
            return $apiarios;
        }

        $pdf = Pdf::loadView('relatorios.apiarios', compact('apiarios'));
        return $pdf;
    }

    public function colmeiaRelatorioPDF(int $id_pessoa, string $format = 'pdf') 
    {
        $apiarios = $this->apiarioRepository->getApiarioByPessoa($id_pessoa);
        $id_apiarios = $apiarios->pluck('id_apiario')->toArray();
        $colmeias = $this->colmeiaRepository->getColmeiasByApiarios($id_apiarios);

        if ($format === 'json') {
            return $colmeias;
        }

        $pdf = Pdf::loadView('relatorios.colmeias', compact('colmeias'));
        return $pdf;
    }
}