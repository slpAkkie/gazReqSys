<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Title -->
        <title>@yield('title', Config::get('app.name'))</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        @yield('css')

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>

        @yield('header-js')
    </head>
    <body>
        @yield('body')

        @yield('footer-js')
    </body>
</html>
