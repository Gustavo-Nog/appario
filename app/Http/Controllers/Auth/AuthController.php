<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {        
        $request->merge(['email' => Str::lower($request->email)]);
        $credenciais = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            if (Auth::attempt($credenciais)) {
                if ($request->wantsJson()) {
                    $user = Auth::user();
                    $token = $user->createToken('auth_token')->plainTextToken;

                    return response()->json([
                        'status' => 'success',
                        'token'  => $token,
                        'user'   => $user
                    ], 200);
                }
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            }

            return back()->withErrors(['email' => 'Credenciais inválidas.'])->withInput(); 
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Credenciais inválidas'
                ], 401);
            }

            return back()->withErrors([
                'erro'  => 'Erro no login: ' . $e->getMessage()]);
        }        
    }

    public function logout (Request $request)
    {
        if ($request->wantsJson()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message' => 'Token revogado com sucesso'
            ], 200);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
