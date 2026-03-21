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
                'message' => 'Se o email existir, um link de redefinição de senha será enviado para o seu email.' 
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
                'Se o email existir, um link de redefinição de senha será enviado para o seu email.'
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