<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appário - Página em Construção</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('favicon-32x32.png') }}" type="image/x-icon" />
    <link href="{{ asset('css/pages/emconstrucao.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('img/appAriologo.png') }}" alt="logo">
        </div>
        <a href="{{ route('dashboard') }}" class="btn-inicio">início</a>
    </header>

    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <img src="{{ asset('img/emConstrucao.png') }}" alt="Página em Construção">
            <h2>Página em Construção</h2>
        </div>
    </section>

    @include('footer.footer')
</body>
</html>
