<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm(Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Se o e-mail existir, um link de redefinição de senha foi enviado.' 
            ], 200);
        } else {
            return view('usuarios.solicitarSenha');
        }
    }

    public function sendResetLinkEmail(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);
            Password::broker('usuarios')->sendResetLink(
                $request->only('email')     
            );

            return back()->with(
                'status', 
                'Se o e-mail existir, um link de redefinição de senha foi enviado.'
            );
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => 'Erro interno. Tente novamente.'
                ], 500);
            }

            return back()->withErrors([
                'error' => 'Erro ao processar sua solicitação.'
            ])->withInput();
        }
    }
}