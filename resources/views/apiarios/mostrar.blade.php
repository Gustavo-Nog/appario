@extends('layouts.app') {{-- ou o layout que você estiver usando --}}

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Detalhes do Apiário</h1>

    <div class="card p-4 mb-3">
        <h3>Informações Gerais</h3>
        <p><strong>Nome:</strong> {{ $apiario->nome }}</p>
        <p><strong>Data de Criação:</strong> {{ \Carbon\Carbon::parse($apiario->data_criacao)->format('d/m/Y') }}</p>
        <p><strong>Área:</strong> {{ $apiario->area }} hectares</p>
        <p><strong>Coordenadas:</strong> {{ $apiario->coordenadas ?? 'Não informado' }}</p>
    </div>

    <div class="card p-4">
        <h3>Endereço</h3>
        @if($apiario->endereco)
            <p><strong>Estado (UF):</strong> {{ $apiario->endereco->estado }}</p>
            <p><strong>Cidade:</strong> {{ $apiario->endereco->cidade }}</p>
            <p><strong>Logradouro:</strong> {{ $apiario->endereco->logradouro }}</p>
            <p><strong>Número:</strong> {{ $apiario->endereco->numero }}</p>
            <p><strong>Complemento:</strong> {{ $apiario->endereco->complemento ?? '---' }}</p>
            <p><strong>Bairro:</strong> {{ $apiario->endereco->bairro }}</p>
            <p><strong>CEP:</strong> {{ $apiario->endereco->cep }}</p>
        @else
            <p>Endereço não cadastrado.</p>
        @endif
    </div>

    <a href="{{ route('apiarios.index') }}" class="btn btn-secondary mt-3">Voltar</a>
</div>
@endsection
