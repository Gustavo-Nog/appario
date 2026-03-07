{{-- resources/views/pessoas/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Perfil de Pessoa')

@section('content')
  <div class="container">
    <h1 class="mb-4">Perfil de<br> {{ $pessoa->nome }} {{ $pessoa->sobrenome }}</h1>

    <dl class="row">

      <dt class="col-sm-3">Nome</dt>
      <dd class="col-sm-9">{{ $pessoa->nome }}</dd>

      <dt class="col-sm-3">Sobrenome</dt>
      <dd class="col-sm-9">{{ $pessoa->sobrenome }}</dd>

      <dt class="col-sm-3">CPF</dt>
      <dd class="col-sm-9">{{ $pessoa->cpf }}</dd>

      <dt class="col-sm-3">Tipo</dt>
      <dd class="col-sm-9">{{ $pessoa->tipo }}</dd>
    </dl>

    <a href="{{ route('pessoas.edit', $pessoa->id_pessoa) }}" class="btn btn-primary">Editar</a>

    <a href="{{ route('pessoas.delete', $pessoa->id_pessoa) }}" class="btn btn-danger ms-2">
      Excluir
    </a>
  </div>
@endsection
