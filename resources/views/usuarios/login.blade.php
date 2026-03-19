<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Login - Projeto</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="icon" href="{{ asset('img/favicon-32x32.png') }}" type="image/x-icon" />
        <link href="{{ asset('css/components/base.css') }}" rel="stylesheet">

        <link href="{{ asset('css/usuarios/login.css') }}" rel="stylesheet">
    </head>
    <body>
        <header class="header-custom">
            <div class="container-fluid header-content">
                <div class="header-left">
                    <img src="{{ asset('img/appAriologo.png') }}" alt="Logo Appário" width="50" height="50">
                </div>
                <span class="header-title">Login</span>
            </div>
        </header>
        <div class="login-container">
            <h2>Login</h2>
            <a href="{{ route('usuarios.create') }}">Ainda não tenho conta</a>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-bottom: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <label for="email">Email:</label>
                <input type="email" id="email" class="email" name="email" value="{{ old('email') }}"required />
                @error('email')
                    <div style="color:red;">{{ $message }}</div>
                @enderror

                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required />
                @error('password')
                    <div style="color:red;">{{ $message }}</div>
                @enderror

                <div style="text-align:center; margin-top: 10px;">
                    <a href="{{ route('usuarios.solicitarSenha') }}">Esqueceu a senha?</a>
                </div>

                <button type="submit">Entrar</button>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
