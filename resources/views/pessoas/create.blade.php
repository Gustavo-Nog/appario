<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/components/base.css') }}" rel="stylesheet">

    <link href="{{ asset('css/usuarios/form_pessoa_usuario.css') }}" rel="stylesheet">
    <title>Inserir Pessoa</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo" width="60" height="60" class="d-inline-block align-text-top me-2">
            <h1 class="navbar-title m-0">CADASTRO</h1>
        </div>
    </nav>
    <form method="POST" action="{{ route('pessoas.inserir') }}" class="w-100 px-3 px-sm-5">
        @csrf
        <h1>Insira suas informaçoes de usuario</h1>
        <div>
            <label for="Nome">Seu Nome</label>
            <input type="text" name="nome" />
        </div>
        <div>
            <label for="Sobrenome">Seu Sobrenome</label>
            <input type="text" name="sobrenome" />
        </div>
        <div>
            <label for="CPF">Seu CPF</label>
            <input type="text" name="cpf" />
        </div>
        
        <div>
            <label for="Tipo">Função</label>
            <select name="tipo" required>
                <option value="">Selecione...</option>
                <option value="apicultor">APICULTOR</option>
                <option value="responsavel">RESPONSAVEL</option>
            </select>
        </div>
        <input type="hidden" name="usuario_id" value="{{ $usuario_id }}"> 
        <button type="submit" class="button">Cadastrar</button>
    </form>
  </body>
</html>