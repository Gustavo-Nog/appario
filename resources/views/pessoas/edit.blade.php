@extends('layouts.app')

@section('title', 'Editar Perfil')

<link href="{{ asset('css/pessoas/edit.css') }}" rel="stylesheet">
@vite('resources/js/app.js')

@section('content')
  <div class="container">
    <h2 class="mb-4">Edite suas informações</h2>

      <form action="{{ route('pessoas.update', $pessoa->id_pessoa) }}" method="POST" novalidate class="pessoa-form">
        @csrf
        @method('PUT')
        @php 
          $cpf = $pessoa->cpf ?? '';
          $cpfFormatado = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
        @endphp

        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $pessoa->nome) }}" maxlength="50" required />
              @error('nome')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="sobrenome" class="form-label">Sobrenome</label>
              <input type="text" class="form-control @error('sobrenome') is-invalid @enderror" id="sobrenome" name="sobrenome" value="{{ old('sobrenome', $pessoa->sobrenome) }}" maxlength="50" required />
              @error('sobrenome')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="cpf" class="form-label">CPF</label>
              <input type="text" class="form-control @error('cpf') is-invalid @enderror cpf" id="cpf" name="cpf" value="{{ old('cpf', $cpfFormatado) }}" maxlength="14" minlength="14" required />
              @error('cpf')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="cidade" class="form-label">Cidade</label>
              <input type="text" class="form-control @error('cidade') is-invalid @enderror" id="cidade" name="cidade" value="{{ old('cidade', $endereco->cidade ?? '') }}" />
              @error('cidade')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="estado" class="form-label">Estado (UF)<span style="color: red">*</span></label>
              <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" >
                <option value="">Selecione...</option>
                @foreach($ufs as $sigla => $nome)
                  <option value="{{ $sigla }}" {{ old('estado') == $sigla ? 'selected' : '' }}>
                    {{ $nome }}
                  </option>
                @endforeach
              </select>
              @error('estado')
                <div style="color:red;">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <label for="logradouro" class="form-label">Logradouro</label>
              <input type="text" class="form-control @error('logradouro') is-invalid @enderror" id="logradouro" name="logradouro" value="{{ old('logradouro', $endereco->logradouro ?? '') }}" />
              @error('logradouro')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="numero" class="form-label">Número</label>
              <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" value="{{ old('numero', $endereco->numero ?? '') }}" />
              @error('numero')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="complemento" class="form-label">Complemento</label>
              <input type="text" class="form-control @error('complemento') is-invalid @enderror" id="complemento" name="complemento" value="{{ old('complemento', $endereco->complemento ?? '') }}" />
              @error('complemento')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="bairro" class="form-label">Bairro</label>
              <input type="text" class="form-control @error('bairro') is-invalid @enderror" id="bairro" name="bairro" value="{{ old('bairro', $endereco->bairro ?? '') }}" />
              @error('bairro')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="cep" class="form-label">CEP</label>
              <input type="text" class="form-control @error('cep') is-invalid @enderror" id="cep" name="cep" value="{{ old('cep', $endereco->cep ?? '') }}" />
              @error('cep')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="mb-4">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select @error('tipo_pessoa') is-invalid @enderror" id="tipo" name="tipo_pessoa" required>
                <option value="">Selecione o tipo</option>
                <option value="APICULTOR" {{ old('tipo_pessoa', $pessoa->tipo_pessoa) === 'APICULTOR' ? 'selected' : '' }}>APICULTOR</option>
                <option value="RESPONSAVEL" {{ old('tipo_pessoa', $pessoa->tipo_pessoa) === 'RESPONSAVEL' ? 'selected' : '' }}>RESPONSAVEL</option>
            </select>
            @error('tipo_pessoa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mt-3">
          <div class="col-md-6">
            <button type="button" class="button-cancelar" onclick="window.location='{{ route('pessoas.show', $pessoa->id_pessoa) }}'">
              Cancelar
            </button>
          </div>
          <div class="col-md-6">
            <button type="submit" class="button">Atualizar</button>
          </div>
        </div>
      </form>
  </div>
@endsection
