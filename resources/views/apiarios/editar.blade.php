@extends('layouts.app')
@section('content')

<form method="POST" action="{{ route('apiarios.update', $apiario) }}">
    @csrf
    @method('PUT')
    <h1 class="text-center mb-4">Editar Apiário</h1>

    {{-- Nome --}}
    <div>
        <label for="nome">Nome do Apiário<span style="color: red">*</span></label>
        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" id="nome" value="{{ old('nome', $apiario->nome) }}" required />
        @error('nome')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Data de Criação --}}
    <div class="mb-3">
        <label for="data_criacao">Data de Criação<span style="color: red">*</span></label>
        <input type="date" class="form-control @error('data_criacao') is-invalid @enderror" id="data_criacao" name="data_criacao" value="{{ old('data_criacao', $apiario->data_criacao) }}" required />
        @error('data_criacao')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Área --}}
    <div class="mb-3">
        <label for="area">Área (hectare)<span style="color: red">*</span></label>
        <input type="number" step="0.01" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ old('area', $apiario->area) }}" required />
        @error('area')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Coordenadas (opcional) --}}
    <div class="mb-3">
        <label for="coordenadas">Coordenadas (GPS)</label>
        <input type="text" class="form-control @error('coordenadas') is-invalid @enderror" id="coordenadas" name="coordenadas" value="{{ old('coordenadas', $apiario->coordenadas) }}"/>
        @error('coordenadas')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <h3>Localização</h3>

    {{-- Estado --}}
    <div>
        <label for="estado" class="form-label">Estado (UF)<span style="color: red">*</span></label>
        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
            <option value="">Selecione...</option>
            @foreach($ufs as $sigla => $nome)
                <option value="{{ $sigla }}" {{ old('estado', $endereco->estado ?? '') == $sigla ? 'selected' : '' }}>
                    {{ $nome }}
                </option>
            @endforeach
        </select>
        @error('estado')
            <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>

    {{-- Cidade --}}
    <div class="mb-3">
        <label for="cidade" class="form-label">Cidade<span style="color: red">*</span></label>
        <input type="text" class="form-control @error('cidade') is-invalid @enderror" id="cidade" name="cidade" value="{{ old('cidade', $endereco->cidade ?? '') }}" required />
        @error('cidade')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Logradouro --}}
    <div class="mb-3">
        <label for="logradouro" class="form-label">Logradouro<span style="color: red">*</span></label>
        <input type="text" class="form-control @error('logradouro') is-invalid @enderror" id="logradouro" name="logradouro" value="{{ old('logradouro', $endereco->logradouro ?? '') }}" required />
        @error('logradouro')
            <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>

    {{-- Número --}}
    <div class="mb-3">
        <label for="numero">Número<span style="color: red">*</span></label>
        <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" value="{{ old('numero', $endereco->numero ?? '') }}" required />
        @error('numero')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Complemento --}}
    <div class="mb-3">
        <label for="complemento">Complemento</label>
        <input type="text" class="form-control @error('complemento') is-invalid @enderror" id="complemento" name="complemento" value="{{ old('complemento', $endereco->complemento ?? '') }}" />
        @error('complemento')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Bairro --}}
    <div class="mb-3">
        <label for="bairro">Bairro<span style="color: red">*</span></label>
        <input type="text" class="form-control @error('bairro') is-invalid @enderror" id="bairro" name="bairro" value="{{ old('bairro', $endereco->bairro ?? '') }}" required />
        @error('bairro')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- CEP --}}
    <div class="mb-3">
        <label for="cep">CEP<span style="color: red">*</span></label>
        <input type="text" class="form-control @error('cep') is-invalid @enderror" id="cep" name="cep" value="{{ old('cep', $endereco->cep ?? '') }}" required maxlength="10" />
        @error('cep')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="button">Atualizar</button>
</form>
@endsection
