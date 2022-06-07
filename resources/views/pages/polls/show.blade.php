<!doctype html>
<html lang="en">
<head>
    <title>I♥home</title>
    @include('layout.partials.head')
</head>

<body class="d-flex flex-column">
    @include('layout.partials.page.header')
  
    <main role="main" class="flex-grow-1">
	<h1>Výsledky</h1>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Možnosť</th>
                <th scope="col">Počet</th>
            </tr>
        </thead>
        <tbody>
        @foreach($results as $key => $value)
            <tr>
                <td>{{$key}}</td>
                <td>{{$value}}</td> <!--https://stackoverflow.com/questions/3406726/echo-key-and-value-of-an-array-without-and-with-loop-->
            </tr>
        @endforeach
        </tbody>
    </table>
    </main>
    @include('layout.partials.page.footer')
    @include('layout.partials.foot')
</body>
</html> 