@extends('layouts.app')

@section('title', 'Colmeias')

@section('content')
  <link href="{{ asset('css/colmeias/index.css') }}" rel="stylesheet">

  <div class="page-title">Colmeias já cadastradas</div>
        <a href="{{ route('colmeias.relatorio') }}" class="btn btn-warning relatorio-button">
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

        <div>
          <form 
            action="{{ route('apiarios.colmeias.edit', [$colmeia->apiario_id, $colmeia->id_colmeia]) }}" 
            method="GET"
            class="botao-editar"
          >
            <button type="submit" class="btn btn-sm btn-primary mb-1">Editar</button>
          </form>

          <form 
            action="{{ route('apiarios.colmeias.destroy', [$colmeia->apiario_id, $colmeia->id_colmeia]) }}" 
            method="POST" 
            class="button-delete js-delete-form" 
            data-confirm-message="Deseja realmente excluir esta colmeia?"
          >
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
          </form>
        </div>
      </div>
    @endforeach
  @else
    <div class="empty-message">Nenhuma colmeia cadastrada</div>
  @endif

  <a href="{{ route('colmeias.create') }}" class="add-button">+</a>

@endsection
