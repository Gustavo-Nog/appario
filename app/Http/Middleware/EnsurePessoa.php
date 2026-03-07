<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePessoa
{
   
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = auth()->user();

        if (!$usuario) {
            return redirect()->route('login.form');
        }

        $pessoa = $usuario->pessoa ?? null;

        if (!$pessoa) {
            return redirect()->route('apiarios.index')
                ->with('error', 'Pessoa não encontrada para este usuário');
        }

        $request->attributes->set('pessoa', $pessoa);

        return $next($request);
    }
}
