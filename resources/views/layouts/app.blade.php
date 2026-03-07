{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Appário')</title>
  <link rel="icon" href="{{ asset('favicon-32x32.png') }}" type="image/x-icon" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <link href="{{ asset('css/base.css') }}" rel="stylesheet" />

  <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
  @stack('styles')
</head>
<body>
  <header>
    <div class="logo-container">
      <img src="{{ asset('img/appAriologo.png') }}" alt="Logo Appário" />
    </div>

    <nav class="nav-menu">
      <a href="{{ route('dashboard') }}">INÍCIO</a>
      <a href="{{ route('apiarios.index') }}">APIÁRIO</a>
      <a href="{{ route('colmeias.index') }}">COLMEIA</a>
      <a href="{{ route('inspecao.construcao') }}">INSPEÇÃO</a>
    </nav>

    {{-- Ícone do usuário (aparece só em rotas específicas) --}}
    @auth
      @php
        $pessoa = auth()->user()->pessoa ?? null;
      @endphp

      @if ($pessoa && (Route::is('dashboard') || Route::is('colmeias.*') || Route::is('apiarios.*')))
        <div class="user-menu dropdown">
          <a href="#" role="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false" title="Menu do Usuário">
            <i class="bi bi-person-circle text-white" style="font-size: 2rem;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userMenu">
            <li>
              <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('pessoas.show', $pessoa->id_pessoa) }}">
                <i class="bi bi-person-lines-fill"></i> Ver Perfil
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('pessoas.edit', $pessoa->id_pessoa) }}">
                <i class="bi bi-pencil-square"></i> Editar Perfil
              </a>
            </li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="dropdown-item d-flex align-items-center gap-2" type="submit">
                  <i class="bi bi-box-arrow-right"></i> Sair
                </button>
              </form>
            </li>
            <li>
              <form method="POST" action="{{ route('pessoas.destroy', $pessoa->id_pessoa) }}" onsubmit="return confirm('Tem certeza que deseja deletar sua conta?');">
                @csrf
                @method('DELETE')
                <button class="dropdown-item d-flex align-items-center gap-2 text-danger" type="submit">
                  <i class="bi bi-trash3"></i> Deletar Conta
                </button>
              </form>
            </li>
          </ul>
        </div>
      @endif
    @endauth
  </header>

  <main class="py-4 position-relative z-1">
    @yield('content')
  </main>

  <img class="hex-background" src="{{ asset('img/backgroundImg.png') }}" alt="Fundo Hexágonos" />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>