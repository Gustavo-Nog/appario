@extends('layouts.app')
@section('title', 'Lista de Pessoas')

<link href="{{ asset('css/pessoas/listar.css') }}" rel="stylesheet">


@section('content')
<div class="container">
    <div class="title-page d-flex justify-content-center">
        <h1 class="text-uppercase">Usuários</h1>
    </div>
    <table class="table-pessoas">
        <thead class="table-head">
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>CPF</th>
                <th class="email-col">EMAIL</th>
                <th>FUNÇÃO</th>
                <th>APIÁRIOS</th>
                <th>COLMEIAS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pessoas as $pessoa)
                <tr class="body-pessoas" onclick="window.location='{{ route('pessoas.perfil', $pessoa->id_pessoa) }}'">
                    <td data-label="ID">{{ $pessoa->id_pessoa }}</td>
                    <td data-label="Nome">{{ $pessoa->nome }} {{ $pessoa->sobrenome }}</td>
                    <td data-label="CPF" class="programacao cpf">{{ $pessoa->cpf ?? 'Não Informado'}}</td>
                    <td data-label="Email" class="email-col">{{ $pessoa->usuario->email ?? 'Não informado' }}</td>
                    <td data-label="Função">{{ $pessoa->tipo_pessoa }}</td>
                    <td data-label="Apiários">{{ $pessoa->apiarios->count() }}</td>
                    <td data-label="Colmeias">{{ $pessoa->colmeias_count }}</td>
                    <td data-label="acoes" class="acoes">
                        <a href="{{ route('pessoas.edit', $pessoa->id_pessoa) }}" class="btn btn-primary me-2">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('pessoas.destroy', $pessoa->id_pessoa) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Confirma exclusão desta pessoa?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="container-pagination">
        {{ $pessoas->links() }}
    </div>
    <div class="mt-2 d-flex justify-content-end text-center">
        <a href="{{ route('usuarios.create', ['origem' => 'listar']) }}">
            <button class="btn btn-primary">Adicionar usuário</button>
        </a>
    </div>

</div>

@endsection