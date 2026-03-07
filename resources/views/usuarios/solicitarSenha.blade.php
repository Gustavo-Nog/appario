<!DOCTYPE html>
<html lang="pt-br">
  
<head>
    <meta charset="UTF-8">
    <title>Nova Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon-32x32.png') }}" type="image/x-icon" />
    <link href="{{ asset('css/usuarios/redefinir_senha.css') }}" rel="stylesheet">
</head>
    <div class="bg-white p-4 rounded shadow" style="max-width:400px; width:100%;">
        <h3 class="text-center mb-4">Recuperar Senha</h3>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('usuarios.email') }}">
            @csrf
            <label for="email">Digite seu e-mail:</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control mb-3" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-warning w-100">Enviar link</button>

            <div class="text-center mt-3">
                <a href="{{ route('login.form') }}">Voltar ao login</a>
            </div>
        </form>
    </div>
</body>
</html>
