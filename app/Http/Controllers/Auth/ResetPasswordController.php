<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Exception;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * showResetForm: Exibe o formulário de redefinição de senha, passando o token e o e-mail para a view.
     * resetPassword: Atualiza a senha do usuário, hashando a nova senha e gerando novo token
     * sendRestResponse: Redireciona o usuário para a rota de login.
     */

    public function showResetForm(Request $request, string $token)
    {
        return view('usuarios.redefinirSenha')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    protected function resetPassword($usuario, string $password)
    {
        try {
            $usuario->password = Hash::make($password);
            $usuario->setRememberToken(Str::random(60));
            $usuario->save();

        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Erro ao redefinir senha:'])->withInput();
            throw $e;
        }
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return redirect()->route('login.form') 
            ->with('success', 'Sua senha foi alterada com sucesso! Agora você já pode fazer login.');
    }
}       
