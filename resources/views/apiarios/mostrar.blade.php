@extends('layouts.app') {{-- ou o layout que você estiver usando --}}
@section('title', 'Detalhes do Apiário')
@push('styles')
<link href="{{ asset('css/apiarios/mostrar.css') }}" rel="stylesheet" />
@endpush
@section('content')
<div class="container mt-2">

    <div class="card card-apiario p-3 mb-2">
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

    <div class="card card-apiario-endereco p-3 mb-2">
        <h3 class="card-title d-flex justify-content-center">Endereço</h3>
        @if($endereco)
            <div class="row">
            <div class="col-12 col-md-6">
                 <div class="endereco">
                    <p class="info-apiario">Estado: </p>
                    <p class="info-value-apiario"> {{ $endereco->estado_nome ?? $endereco->estado ?? 'Não informado' }}</p>
                </div>
                <div class="endereco">
                    <p class="info-apiario">Cidade: </p>
                    <p class="info-value-apiario"> {{ $endereco->cidade ?? 'Não informado' }}</p>
                </div>
                <div class="endereco">
                    <p class="info-apiario">Bairro: </p>
                    <p class="info-value-apiario"> {{ $endereco->bairro ?? 'Não informado' }}</p>
                </div>
                <div class="endereco">
                    <p class="info-apiario">CEP: </p>
                    <p class="info-value-apiario"> {{ $endereco->cep ?? 'Não informado' }}</p>
                </div>
            </div>
            
            <div class="col-12 col-md-6">
                <div class="endereco">
                    <p class="info-apiario">Logradouro: </p>
                    <p class="info-value-apiario"> {{ $endereco->logradouro  ?? 'Não informado' }}</p>
                </div>
                <div class="endereco">
                    <p class="info-apiario">Número: </p>
                    <p class="info-value-apiario"> {{ $endereco->numero ?? 'Não informado' }}</p>
                </div>
                <div class="endereco">
                    <p class="info-apiario">Complemento: </p>
                    <p class="info-value-apiario"> {{ $endereco->complemento ?? 'Não informado' }}</p>
                </div>
            </div>
            </div>
        @else
            <h5 class="d-flex text-center">Nenhum endereço cadastrado.</h5>
        @endif
    </div>

    <div class="container-botoes">
        <a href="{{ route('apiarios.index') }}" class="btn btn-danger btn-voltar">Voltar</a>
        <a href="{{ route('apiarios.edit', $apiario->id_apiario) }}" class="btn btn-primary btn-editar">Editar</a>
    </div>


</div>
@endsection
