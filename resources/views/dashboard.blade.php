@extends('layouts.app')

@section('title', 'Dashboard - Appário')

@section('content')
  @php
      $pessoa = request()->attributes->get('pessoa');
      $isResponsavel = $pessoa->tipo_pessoa === 'RESPONSAVEL';
      $route = $isResponsavel ? 'pessoas.listar' : 'apicultor.construcao';
  @endphp
  @push('styles')
    <link href="{{ asset('css/pages/dashboard.css') }}" rel="stylesheet">
  @endpush

  <div class="dashboard-container">
    <a href="{{ route('apiarios.index') }}" class="dashboard-card">
      <h2>APIÁRIOS</h2>
      <img src="{{ asset('img/apiarioPng.png') }}" alt="Apiários" />
    </a>
    <a href="{{ route('colmeias.index') }}" class="dashboard-card">
      <h2>COLMEIAS</h2>
      <img src="{{ asset('img/favosDemel.png') }}" alt="Colmeias" />
    </a>
    <a href="{{ route('inspecao.construcao') }}" class="dashboard-card">
      <h2>INSPEÇÕES</h2>
      <img src="{{ asset('img/favosPng.png') }}" alt="Inspeções" />
    </a>
    @if($isResponsavel)
      <a href="{{ route($route) }}" class="dashboard-card">
        <h2>APICULTORES</h2>
        <img src="{{ asset('img/apicultor.png') }}" alt="Apicultor" />
      </a>
    @else
      <a href="{{ route('pessoas.show', $pessoa->id_pessoa) }}" class="dashboard-card">
        <h2>PERFIL</h2>
        <img src="{{ asset('img/apicultor.png') }}" alt="Apicultor" />
      </a>
    @endif
  </div>
@endsection
