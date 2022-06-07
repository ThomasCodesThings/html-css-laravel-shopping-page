<!doctype html>
<html lang="en">
<head>
    <title>I♥home</title>
    @include('layout.partials.head')
</head>

<body>
    @include('layout.partials.page.header')

    <main role="main" class ="height">
        @yield('content')
    </main>

    @include('layout.partials.page.footer')
    @include('layout.partials.foot')
</body>
</html> 