{{-- resources/views/pessoas/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Perfil de Pessoa')

@push('styles')
<link href="{{ asset('css/pessoas/show.css') }}" rel="stylesheet" />
@endpush
@vite('resources/js/app.js')
@php
  $pessoaLogada = request()->attributes->get('pessoa');
  $isProfile = $pessoaLogada && $pessoaLogada->id_pessoa === $pessoa->id_pessoa;
  $isResponsavel = $pessoaLogada && $pessoaLogada->tipo_pessoa === 'RESPONSAVEL';
  $id_pessoa = $isProfile ? $pessoaLogada->id_pessoa : $pessoa->id_pessoa;
@endphp

@section('content')
  <div class="container-fluid titulo mb-3">
    <div class="row align-items-center">
      <div class="col-6 col-md-6 mt-3 mt-md-0">
        @if($isProfile)
          <h1 class="mb-0">SEU PERFIL</h1>
        @else
          <h1 class="mb-0 text-uppercase ">PERFIL DE {{ $pessoa->nome }}</h1>
        @endif
      </div>

      @if($isProfile || $isResponsavel)
        <div class="col-6 col-md-6 text-md-end mt-3 mt-md-0 botoes-perfil">
          <a href="{{ route('pessoas.edit', $id_pessoa) }}" class="btn btn-primary me-2">
            <i class="bi bi-pencil"></i>
            <span class="d-none d-md-inline"> Editar perfil</span>
          </a>

          <form action="{{ route('pessoas.destroy', $id_pessoa) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Confirma exclusão desta pessoa?')">
              <i class="bi bi-trash"></i>
              <span class="d-none d-md-inline"> Excluir perfil</span>
            </button>
          </form>
        </div>
      @else

      @endif
    </div>
  </div>

  <div class="conteudo-perfil container-fluid">
    <div class="row align-items-center mb-4">
      <div class="col-auto d-flex align-items-center gap-3">
        <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
        <div>
          <h3 class="mb-0">{{ $pessoa->nome }} {{ $pessoa->sobrenome }}</h3>
          <small class="text-muted">{{ $pessoa->tipo_pessoa ?? $pessoa->tipo }}</small>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="info-grid">
          <div class="info-card">
            <h5>Nome</h5>
            <div class="info-value">{{ $pessoa->nome }}</div>
          </div>

          <div class="info-card">
            <h5>Sobrenome</h5>
            <div class="info-value">{{ $pessoa->sobrenome }}</div>
          </div>

          <div class="info-card">
            <h5>CPF</h5>
            <div class="info-value cpf">{{ $pessoa->cpf ?? 'Não informado' }}</div>
          </div>

          <div class="info-card">
            <h5>E-mail</h5>
            <div class="info-value">{{ $pessoa->usuario->email ?? '—' }}</div>
          </div>

          <div class="info-card">
            <h5>Apiários</h5>
            <div class="info-value">{{ $pessoa->apiarios->count() ?: 'Nenhum apiário' }}</div>
          </div>

          <div class="info-card">
            <h5>Colmeias</h5>
            <div class="info-value">{{ $totalColmeias ?? 'Nenhuma colmeia' }}</div>
          </div>

          <h2>Endereço</h2>
          <div></div>
          
          <div class="info-card">
            <h5>Estado</h5>
            <div class="info-value">{{ $endereco->estado ?? 'Não informado' }}</div>
          </div>

          <div class="info-card">
            <h5>Cidade</h5>
            <div class="info-value">{{ $endereco->cidade ?? 'Não informado' }}</div>
          </div>

          <div class="info-card">
            <h5>CEP</h5>
            <div class="info-value cep">{{ $endereco->cep ?? 'Não informado' }}</div>
          </div>

          <div class="info-card">
            <h5>Bairro</h5>
            <div class="info-value">{{ $endereco->bairro ?? 'Não informado' }}</div>
          </div>

          <div class="info-card">
            <h5>Logradouro</h5>
            <div class="info-value">{{ $endereco->logradouro ?? 'Não informado' }}</div>
          </div>

          <div class="info-card">
            <h5>Número</h5>
            <div class="info-value">{{ $endereco->numero ?? 'Não informado' }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
