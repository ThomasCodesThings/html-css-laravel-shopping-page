<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layout.partials.head')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>I♥home</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased d-flex flex-column">
        <div class="flex-grow-1 bg-gray-100">

            <!-- Page Heading -->
            @include('layout.partials.page.header')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @include('layout.partials.page.footer')
        @include('layout.partials.foot')
    </body>
</html>
