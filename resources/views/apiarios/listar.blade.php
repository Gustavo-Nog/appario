@extends('layouts.app')

@section('title', 'Apiários')
<link href="{{ asset('css/apiarios/listar.css') }}" rel="stylesheet">

@section('content')

  <div class="page-title">Apiários já adicionados</div>
        <a href="{{ route('apiarios.relatorio') }}" class="btn btn-warning relatorio-button">
          📄 Gerar Relatório
        </a>

  @if($apiarios->count() > 0)
    @foreach($apiarios as $apiario)
      <div onclick="window.location='{{ route('apiarios.mostrar', $apiario->id_apiario) }}'" class="apiario-card">
        <div class="apiario-info">
          <div class="apiario-nome">{{ $apiario->nome }}</div>
          <div class="apiario-local">Apiário N°{{ $apiario->id_apiario }}</div>
        </div>
        <div class="apiario-tipo">
          {{ $apiario->enderecos->cidade ?? 'Sem cidade' }}<br>
           Colmeias: {{ $apiario->colmeias_count }}
        </div>

        {{-- Botões de ação --}}
        <div class="botao-editar" onclick="event.stopPropagation();">
          <a href="{{ route('apiarios.edit', $apiario->id_apiario) }}" class="btn btn-sm btn-primary">Editar</a>

          <form action="{{ route('apiarios.destroy', $apiario->id_apiario) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Deseja realmente excluir este apiário?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
          </form>
        </div>
      </div>
    @endforeach
  @else
    <div class="empty-message">Nenhum apiário cadastrado</div>
  @endif

  <a href="{{ route('apiarios.adicionar') }}" class="add-button">+</a>
@endsection
