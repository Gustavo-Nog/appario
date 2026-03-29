<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  @extends('layouts.app')

  @section('title', 'Cadastro de Colmeia')

  <link href="{{ asset('css/colmeias/create.css') }}" rel="stylesheet">

  @section('content')
    <div class="form-wrapper">
      <form method="POST" action="{{ route('colmeias.store') }}" class="colmeia-form">
        @csrf
        <h1 class="text-center mb-4">Informe os dados da Colmeia</h1>

        {{-- Espécie --}}
        <div>
          <label for="especie">Espécie<span style="color: red">*</span></label>
          <input type="text" class="form-control @error('especie') is-invalid @enderror" name="especie" id="especie" value="{{ old('especie') }}" required />
          @error('especie')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Tamanho --}}
        <div>
          <label for="tamanho">Tamanho<span style="color: red">*</span></label>
          <input type="text" class="form-control @error('tamanho') is-invalid @enderror" name="tamanho" id="tamanho" value="{{ old('tamanho') }}" required />
          @error('tamanho')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Data Aquisição --}}
        <div class="mb-3">
          <label for="data_aquisicao">Data de Aquisição<span style="color: red">*</span></label>
          <input type="date" class="form-control @error('data_aquisicao') is-invalid @enderror" id="data_aquisicao" name="data_aquisicao" value="{{ old('data_aquisicao') }}" required />
          @error('data_aquisicao')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Apiário --}}
        <div>
          <label for="apiario_id" class="form-label">Apiário<span style="color: red">*</span></label>
          <select class="form-select @error('apiario_id') is-invalid @enderror" id="apiario_id" name="apiario_id" required>
            <option value="">Selecione...</option>
            @foreach($apiarios as $apiario)
              <option value="{{ $apiario->id_apiario }}" {{ old('apiario_id') == $apiario->id_apiario ? 'selected' : '' }}>
                {{ $apiario->nome }}
              </option>
            @endforeach
          </select>
          @error('apiario_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="button">Cadastrar</button>
      </form>
    </div>
  @endsection