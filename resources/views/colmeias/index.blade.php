@extends('layouts.app')

@section('title', 'Colmeias')

@section('content')
  <link href="{{ asset('css/colmeias/index.css') }}" rel="stylesheet">

  <div class="page-title">Colmeias já cadastradas</div>
        <a href="{{ route('colmeias.relatorio') }}" target="_blank" class="btn btn-warning relatorio-button">
            📄 Gerar Relatório
        </a>

  @if($colmeias->count() > 0)
    @foreach($colmeias as $colmeia)
      <div class="colmeia-card">
        <div class="colmeia-info">
            <div class="colmeia-especie">{{ $colmeia->especie }}</div>
            <div class="colmeia-detalhes">
              Tamanho: {{ $colmeia->tamanho }}<br>
              Aquisição: {{ \Carbon\Carbon::parse($colmeia->data_aquisicao)->format('d/m/Y') }}
            </div>
        </div>
        <div class="colmeia-apiario">
            Apiário: {{ $colmeia->apiario->nome ?? 'Sem apiário' }}
        </div>
      </div>
    @endforeach
  @else
    <div class="empty-message">Nenhuma colmeia cadastrada</div>
  @endif

  <a href="{{ route('colmeias.create') }}" class="add-button">+</a>

@endsection
