<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ApiarioController;
use App\Http\Controllers\ColmeiaController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::post('/login', [AuthController::class, 'login']);
Route::apiResource('usuarios', UsuarioController::class)->parameters([
    'usuarios' => 'id_usuario'
]);
Route::apiResource('pessoas', PessoaController::class)->parameters([
    'pessoas' => 'id_pessoa'
]);

Route::middleware(['auth:sanctum', 'ensure.pessoa'])->group(function() {
    Route::apiResource('apiarios', ApiarioController::class)->parameters([
        'apiarios' => 'id_apiario'
    ]);
    Route::get('/relatorio-apiarios', [ApiarioController::class, 'gerarRelatorioPDF'])->name('apiarios.relatorio');

    Route::get('/colmeias', [ColmeiaController::class, 'index']);
    Route::get('/relatorio-colmeias', [ColmeiaController::class, 'gerarRelatorioPDF'])->name('colmeias.relatorio');

    Route::apiResource('apiarios.colmeias', ColmeiaController::class)
        ->only(['store','show','update','destroy'])
        ->parameters([
            'apiarios' => 'id_apiario',
            'colmeias' => 'id_colmeia',
        ]);
});