@extends('layouts.app')
@section('title', 'Colmeia')
<link href="{{ asset('css/apiarios/mostrar.css') }}" rel="stylesheet" />
@section('content')
<div class="container">
    <div class="card card-colmeia">
        <div class="card-header d-flex justify-content-center">
            <h2 class="titulo-card-colmeia">Detalhes da Colmeia</h2>
        </div>
        <div class="card-body">
            <div class="p-1">
                <p class="info-colmeia">ID: </p>
                <p class="info-value-colmeia">{{ $colmeia->id_colmeia }}</p>
            </div>
            <div class="p-1">
                <p class="info-colmeia">Apiário: </p>
                <p class="info-value-colmeia">{{ $colmeia->apiario->nome }}</p>
            </div>
            <div class="p-1">
                <p class="info-colmeia">Espécie: </p>
                <p class="info-value-colmeia">{{ $colmeia->especie }}</p>
            </div>
            <div class="p-1">
                <p class="info-colmeia">Tamanho</p>
                <p class="info-value-colmeia">{{ $colmeia->tamanho }}</p>
            </div>
            <div class="p-1">
                <p class="info-colmeia">Criação: </p>
                <p class="info-value-colmeia">{{ \Carbon\Carbon::parse($colmeia->data_aquisicao)->format('d/m/Y') }}</p>
            </div>

        </div>
    </div>

    <div class="container-botoes">
        <a href="{{ route('colmeias.index') }}" class="btn btn-danger btn-voltarn-voltar">Voltar</a>
        <a href="{{ route('apiarios.colmeias.edit', [$colmeia->apiario_id, $colmeia->id_colmeia]) }}" class="btn btn-primary btn-editar">Editar</a>
    </div>
</div>
@endsection