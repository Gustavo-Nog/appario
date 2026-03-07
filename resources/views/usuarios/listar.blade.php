<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="icon" href="{{ asset('favicon-32x32.png') }}" type="image/x-icon" />
    <link href="{{ asset('css/components/base.css') }}" rel="stylesheet">

    <link href="{{ asset('css/usuarios/form_pessoa_usuario.css') }}" rel="stylesheet">
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id_usuario }}</td>
                <td>{{ $usuario->email }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="text-align: center;">
        <a href="{{ route('usuarios.create') }}">
            <button>Novo usuario</button>
        </a>
    </div>
</body>

</html>