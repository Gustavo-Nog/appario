<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pessoas</title>
    <link href="{{ asset('css/components/base.css') }}" rel="stylesheet">

    <link href="{{ asset('css/usuarios/form_pessoa_usuario.css') }}" rel="stylesheet">
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>NOME</th>
                <th>CPF</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pessoas as $pessoa)
            <tr>
                <td>
                    <a href="{{ route('pessoas.show', $pessoa->id_pessoa) }}">
                        {{ $pessoa->nome }} {{ $pessoa->sobrenome }}
                    </a>
                </td>
                <td class="programacao">{{ $pessoa->cpf }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="text-align: center;">
        <a href="{{ route('pessoas.create') }}">
            <button>Nova pessoa</button>
        </a>
    </div>
</body>

</html>