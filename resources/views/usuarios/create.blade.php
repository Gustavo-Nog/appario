<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="icon" href="{{ asset('img/favicon-32x32.png') }}" type="image/x-icon" />
        <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
        <link href="{{ asset('css/components/base.css') }}" rel="stylesheet">
        <link href="{{ asset('css/usuarios/form_pessoa_usuario.css') }}" rel="stylesheet">
        @vite('resources/js/app.js')
        <title>Criar Usuário</title>
  </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <img src="{{ asset('img/appAriologo.png') }}" alt="Logo Appário" width="60" height="60" class="d-inline-block align-text-top me-2">
                <h1 class="navbar-title m-0">CADASTRO</h1>
            </div>
        </nav>

        <form method="POST" action="{{ route('usuarios.store') }}" class="w-100 px-3 px-sm-5" style="max-width: 800px;">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h3 class="mb-3 text-center text-uppercase">Cadastro de Usuário</h3>
            <a href="{{ route('login.form') }}">Já tenho conta</a>

            <div class="row">
                <div class="col-md-6 mt-3 field-email">
                    <label for="email">Seu Email<span class="required">*</span></label>
                    <input type="email" name="email" class="form-control email" placeholder="Digite seu email" required>
                </div>
                <div class="col-md-6 mt-3 field-nome">
                    <label for="nome">Seu Nome<span class="required">*</span></label>
                    <input type="text" name="nome" class="form-control" placeholder="Digite seu nome" required>
                </div>

                <div class="col-md-6 mt-3 field-password">
                    <label for="password">Sua Senha<span class="required">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Digite sua senha" />
                        <button type="button" class="botao-toggle js-toggle-password" aria-label="Mostrar senha">🙈</button>
                    </div>
                </div>
                <div class="col-md-6 mt-3 field-sobrenome">
                    <label for="sobrenome">Seu Sobrenome<span class="required">*</span></label>
                    <input type="text" name="sobrenome" class="form-control" placeholder="Digite seu sobrenome" required>
                </div>

                <div class="col-md-6 mt-3 field-password-confirm">
                    <label for="password_confirmation">Confirme sua senha<span class="required">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirme sua senha" required>
                        <button type="button" class="botao-toggle js-toggle-password" aria-label="Mostrar senha">🙈</button>
                    </div>
                </div>
                <div class="col-md-6 mt-3 field-cpf">
                    <label for="cpf">Seu CPF</label>
                    <input type="text" name="cpf" maxlength="11" class="form-control" placeholder="Digite seu CPF (Opcional)">
                </div>

                <!-- 
                <div class="col-12 mt-3">
                    <label for="tipo">Função</label>
                    <select name="tipo_pessoa" class="form-select">
                        <option value="">Selecione...</option>
                        <option value="APICULTOR">APICULTOR</option>
                        <option value="RESPONSAVEL">RESPONSAVEL</option>
                    </select>
                </div>
                -->

                <div class="col-12 mt-4 field-submit">
                    <button type="submit" class="button w-100 botao-cadastrar-entrar">Cadastrar</button>
                </div>
            </div>
        </form>
    </body>
</html>