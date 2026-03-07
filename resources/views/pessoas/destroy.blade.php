
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Confirmar Exclusão</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="{{ asset('css/nav.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/base.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/pessoas/destroy.css') }}" rel="stylesheet" />
</head>
<body>
    <header class="header-custom">
        <div class="container-fluid header-content">
            <div class="header-left">
                <img src="{{ asset('img/appAriologo.png') }}" alt="Logo Appário" width="50" height="50">
            </div>        
        </div>
    </header>

  <div class="form-wrapper">
    <div class="confirm-box">
      <h1>Confirmar Exclusão</h1>
      <p>Tem certeza que deseja excluir o perfil de <strong>{{ $pessoa->nome }} {{ $pessoa->sobrenome }}</strong>?</p>

      <form action="{{ route('pessoas.destroy', $pessoa->id_pessoa) }}" method="POST">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn-confirm">Sim, excluir</button>
        <a href="{{ route('pessoas.show', $pessoa->id_pessoa) }}" class="btn-cancel">Cancelar</a>
      </form>
    </div>
  </div>
</body>
</html>
@endsection
