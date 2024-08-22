<!-- resources/views/layouts/base.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Meu Acaí - Encontre o Açaí Mais Próximo de Você!" />
    <meta property="og:description" content="Descubra as melhores batedeiras de açaí perto de você e cadastre a sua. Acesse agora e encontre o sabor perfeito!" />
    <meta property="og:image" content="https://im.ge/i/pixelcut-export.KjDhJK" />
    <meta property="og:image:width" content="1200"/>
    <meta property="og:image:height" content="630"/>
    <meta property="og:locale" content="pt_BR"/>
    <meta property="og:url" content="https://meuacai.com" />
    <meta name="theme-color" content="#4B0082">
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Meu Acaí" />
    <meta name="twitter:description" content="Encontre e cadastre as melhores batedeiras de açaí da sua região!" />
    <meta name="twitter:image" content="https://im.ge/i/pixelcut-export.KjDhJK" />
    <meta name="facebook-domain-verification" content="nn6b2r4mz2d5ct3ecfvaur27d4871" />
    
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar/navbar.css') }}">
    <link rel="icon" href="{{ asset('img/logoacai.ico') }}" type="image/x-icon">
    @livewireStyles
</head>
<body>
    @include('layouts.navigation')
    
    <div class="container">
        @yield('content')
    </div>

    @include('layouts.footer')
    
    <script src="{{ asset('js/navbar/footer.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    @livewireScripts
</body>
</html>
