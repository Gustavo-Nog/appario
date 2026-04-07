@extends('layouts.app') {{-- ou o layout que você estiver usando --}}
@section('title', 'Detalhes do Apiário')
@push('styles')
<link href="{{ asset('css/apiarios/mostrar.css') }}" rel="stylesheet" />
@endpush
@section('content')
<div class="container mt-2">

    <div class="card p-3 mb-2">
        <h3 class="card-title d-flex justify-content-center pb-3">Informações Gerais</h3>
        <div class="row">
            <div class="col-6 container-apiario">
                <div class="informacoes-gerais">
                    <p class="info-apiario">Nome do Apiário: </p> <p class="info-value-apiario">{{ $apiario->nome }}</p>
                </div>
                <div class="informacoes-gerais">
                    <p class="info-apiario">Criação: </p> <p class="info-value-apiario">{{ \Carbon\Carbon::parse($apiario->data_criacao)->format('d/m/Y') }}</p>            
                </div>
                <div class="informacoes-gerais">
                    <p class="info-apiario">Área: </p> <p class="info-value-apiario">{{ $apiario->area }}</p>
                </div>
                <div class="informacoes-gerais">
                    <p class="info-apiario">Coordenadas: </p> <p class="info-value-apiario">{{ $apiario->coordenadas ?? 'Não informado' }}</p>
                </div>
            </div>
            <div class="col-6 container-colmeia">
                <div class="informacoes-colmeias">
                    <p>Total de Colmeias</p>
                </div>
                 <h1 class="colmeias-count">
                    {{ $apiario->colmeias->count() }}
                </h1>
            </div>
        </div>
        
        
    </div>

    <div class="card p-3 mb-2">
        <h3 class="card-title d-flex justify-content-center">Endereço</h3>
        @if($apiario->endereco)
            <div class="endereco">
                <p> {{ $apiario->endereco->estado }}</p>
            </div>
            <div class="endereco">
                <p> {{ $apiario->endereco->cidade }}</p>
            </div>
            <div class="endereco">
                <p> {{ $apiario->endereco->logradouro }}</p>
            </div>
            <div class="endereco">
                <p> {{ $apiario->endereco->numero }}</p>
            </div>
            <div class="endereco">
                <p> {{ $apiario->endereco->numero }}</p>
            </div>
            <div class="endereco">
                <p> {{ $apiario->endereco->complemento ?? '---' }}</p>
            </div>
            <div class="endereco">
                <p> {{ $apiario->endereco->bairro }}</p>
            </div>
            <div class="endereco">
                <p> {{ $apiario->endereco->cep }}</p>
            </div>
        @else
            <p>Nenhum endereço cadastrado.</p>
        @endif
    </div>

    <a href="{{ route('apiarios.index') }}" class="btn btn-secondary mt-3">Voltar</a>

</div>
@endsection
