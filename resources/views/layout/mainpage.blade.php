<!doctype html>
<html lang="en">
<head>
    <title>I♥home</title>
    @include('layout.partials.head')
</head>

<body class="d-flex flex-column">
    @include('layout.partials.page.header')
    @include('layout.partials.page.banner')
  
    <main role="main" class="flex-grow-1">
        @yield('content')
    </main>
    @include('layout.partials.page.footer')
    @include('layout.partials.foot')
</body>
</html> 