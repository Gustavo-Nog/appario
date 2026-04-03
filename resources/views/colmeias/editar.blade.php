@extends('layouts.app')
@section('title', 'Colmeias')

<link href="{{ asset('css/colmeias/create.css') }}" rel="stylesheet">

@section('content')
<div class="form-wrapper">
    <form method="POST" action="{{ route('apiarios.colmeias.update', [$colmeia->apiario_id, $colmeia->id_colmeia]) }}" class="colmeia-form">
        <h1 class="text-center mb-2">Editar colmeia</h1>
        <hr class="separator"/>
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="especie">Espécie</label>
            <input
                type="text"
                id="especie"
                name="especie"
                class="form-control @error('especie') is-invalid @enderror"
                value="{{ old('especie', $colmeia->especie) }}"
            >
            @error('especie')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="tamanho">Tamanho</label>
            <input type="text" class="form-control @error('tamanho') is-invalid @enderror" name="tamanho" id="tamanho" value="{{ old('tamanho', $colmeia->tamanho) }}" required />
            @error('tamanho')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="data_aquisicao">Data de Aquisição</label>
            <input 
                type="text" 
                class="form-control @error('data_aquisicao') is-invalid @enderror" name="data_aquisicao" id="data_aquisicao" 
                value="{{ old('data_aquisicao', $colmeia->data_aquisicao ? \Carbon\Carbon::parse($colmeia->data_aquisicao)->format('Y-m-d') : '') }}" required 
            />
            @error('data_aquisicao')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Apiário --}}
        <div>
          <label for="apiario_id" class="form-label">Apiário<span style="color: red">*</span></label>
          <select class="mb-2 form-select @error('apiario_id') is-invalid @enderror" id="apiario_id" name="apiario_id" required>
            <option value="">Selecione...</option>
            @foreach($apiarios as $apiario)
              <option value="{{ $apiario->id_apiario }}" {{ old('apiario_id', $colmeia->apiario_id) == $apiario->id_apiario ? 'selected' : '' }}>
                {{ $apiario->nome }}
              </option>
            @endforeach
          </select>
          @error('apiario_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="button">
            Atualizar
        </button>
    </form>
</div>
@endsection
