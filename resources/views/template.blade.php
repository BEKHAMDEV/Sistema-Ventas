<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="MatiasPalmero" />
        <title>Sistema ventas - @yield('title')</title>
        <link rel="shortcut icon" href="{{ asset('css/logo_tienda.svg') }}">
        <link href="{{ asset('css/template.css') }}" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        @stack('css')
    </head>
    @auth
        <body class="sb-nav-fixed">

            <x-navigation-header/>

            <div id="layoutSidenav">

                <x-navigation-menu/>

                <div id="layoutSidenav_content">
                    <main>
                        @yield('content')
                    </main>
                    <x-footer/>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> --}}
            <script src="{{ asset('js/scripts.js')}}"></script>
            @stack('js')
        </body>
    @endauth
    @guest
        @include('pages.401')
    @endguest
</html>
