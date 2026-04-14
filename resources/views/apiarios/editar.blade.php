@extends('layouts.app')
@section('content')

<link href="{{ asset('css/apiarios/adicionar.css') }}" rel="stylesheet">

<div class="form-wrapper">
    <form method="POST" action="{{ route('apiarios.update', $apiario) }}" class="apiario-form row">
        @csrf
        @method('PUT')
        <h1 class="text-center mb-4">Editar Apiário</h1>

        <div class="col-md-6 col-12 field-nome-apiario">
            <label for="nome">Nome do Apiário<span style="color: red">*</span></label>
            <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" id="nome" value="{{ old('nome', $apiario->nome) }}" required />
            @error('nome')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 col-12 field-data">
            <label for="data_criacao">Data de Criação<span style="color: red">*</span></label>
            <input type="date" class="form-control @error('data_criacao') is-invalid @enderror" id="data_criacao" name="data_criacao" value="{{ old('data_criacao', $apiario->data_criacao ? \Carbon\Carbon::parse($apiario->data_criacao)->format('Y-m-d') : '') }}" required />
            @error('data_criacao')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 col-12 field-area">
            <label for="area">Área (hectare)<span style="color: red">*</span></label>
            <input type="number" step="0.01" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ old('area', $apiario->area) }}" required />
            @error('area')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 col-12 field-coordenadas">
            <label for="coordenadas">Coordenadas (GPS)</label>
            <input type="text" class="form-control @error('coordenadas') is-invalid @enderror" id="coordenadas" name="coordenadas" value="{{ old('coordenadas', $apiario->coordenadas) }}" placeholder="Latitude, Longitude (ex: 00.0000, 00.0000)"/>
            @error('coordenadas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 col-12 field-estado">
            <label for="estado" class="form-label">Estado (UF)<span style="color: red">*</span></label>
            <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
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

        <div class="col-md-6 col-12 field-bairro">
            <label for="bairro">Bairro<span style="color: red">*</span></label>
            <input type="text" class="form-control @error('bairro') is-invalid @enderror" id="bairro" name="bairro" value="{{ old('bairro', $endereco->bairro ?? '') }}" required />
            @error('bairro')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 col-12 field-numero">
            <label for="numero">Número<span style="color: red">*</span></label>
            <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" value="{{ old('numero', $endereco->numero ?? '') }}" required />
            @error('numero')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 col-12 field-cep">
            <label for="cep">CEP<span style="color: red">*</span></label>
            <input type="text" class="form-control @error('cep') is-invalid @enderror" id="cep" name="cep" value="{{ old('cep', $endereco->cep ?? '') }}" required maxlength="10" placeholder="00000-000"/>
            @error('cep')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 col-12 field-cidade">
            <label for="cidade" class="form-label">Cidade<span style="color: red">*</span></label>
            <input type="text" class="form-control @error('cidade') is-invalid @enderror" id="cidade" name="cidade" value="{{ old('cidade', $endereco->cidade ?? '') }}" required />
            @error('cidade')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 col-12 field-logradouro">
            <label for="logradouro" class="form-label">Logradouro<span style="color: red">*</span></label>
            <input type="text" class="form-control @error('logradouro') is-invalid @enderror" id="logradouro" name="logradouro" value="{{ old('logradouro', $endereco->logradouro ?? '') }}" required />
            @error('logradouro')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 col-12 field-complemento">
            <label for="complemento">Complemento</label>
            <input type="text" class="form-control @error('complemento') is-invalid @enderror" id="complemento" name="complemento" value="{{ old('complemento', $endereco->complemento ?? '') }}" />
            @error('complemento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 field-submit">
          <div class="row">
            <div class="col-md-6 col-12">
              <button type="button" class="button-cancelar" onclick="window.location='{{ route('apiarios.index') }}'">
                Cancelar
              </button>
            </div>
            <div class="col-md-6 col-12">
              <button type="submit" class="button">Atualizar</button>
            </div>
          </div>
        </div>
    </form>
</div>
@endsection
