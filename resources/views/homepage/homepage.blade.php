<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appário - Homepage</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('img/favicon-32x32.png') }}" type="image/x-icon" />
    <link href="{{ asset('css/pages/homepage.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('img/appAriologo.png') }}" alt="logo">
        </div>
        <button class="menu-toggle" id="menuToggle" aria-controls="nav-buttons" aria-expanded="false" aria-label="Abrir menu">☰</button>
        <div class="nav-buttons" id="nav-buttons">
            <a href="{{ route('usuarios.create') }}" class="btn-criar">criar conta</a>
            <a href="{{ route('login.form') }}" class="btn-login">login</a>
        </div>
    </header>

    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Bem vindo(a) ao Appário!</h1>
            <h3>Gerencie seu apiário com rapidez e eficiência.</h3>
            <p>Organize colmeias, produções, inspeções e muito mais com uma facilidade que só o nosso sistema pode proporcionar.</p>
            <a href="{{ route('usuarios.create') }}" class="btn-criar">comece agora!</a>
        </div>
    </section>

    @include('footer.footer')

    @vite('resources/js/app.js')
</body>
</html>