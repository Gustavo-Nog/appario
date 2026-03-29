@extends('layouts.app')

@section('title', 'Colmeias')

@section('content')
    <h1>Editar Colmeia</h1>

    <form action="{{ route('apiarios.colmeias.update', $colmeia) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="especie">Espécie</label>
            <input
                type="text"
                id="especie"
                name="especie"
                class="form-control"
                value="{{ old('especie', $colmeia->especie) }}"
            >
        </div>

        <button type="submit" class="btn btn-primary">
            Salvar
        </button>
    </form>
@endsection
