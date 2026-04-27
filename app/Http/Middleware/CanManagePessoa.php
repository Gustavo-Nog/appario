<?php

namespace App\Http\Middleware;

use App\Repositories\PessoaRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanManagePessoa
{
    public function __construct(protected PessoaRepository $pessoaRepository) {}

    public function handle(Request $request, Closure $next): Response
    {
        $pessoa = $request->attributes->get('pessoa');
        if (!$pessoa) {
            abort(401, 'Pessoa não autenticada.');
        }

        $idPessoa = (int) $request->route('id_pessoa');
        if (!$idPessoa) {
            abort(400, 'ID da pessoa é obrigatório.');
        }

        $pessoaAlvo = $this->pessoaRepository->getPessoaById($idPessoa);
        $pessoaLogada = (int) $pessoa->id_pessoa === (int) $pessoaAlvo->id_pessoa;
        $isResponsavel = $pessoa->tipo_pessoa === 'RESPONSAVEL';
        if (!$pessoaLogada && !$isResponsavel) {
            abort(403, 'Acesso negado.');
        }
        return $next($request);
    }
}