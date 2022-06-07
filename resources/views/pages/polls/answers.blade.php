<!doctype html>
<html lang="en">
<head>
    <title>I♥home</title>
    @include('layout.partials.head')
</head>

<body class="d-flex flex-column">
    @include('layout.partials.page.header')
  
    <main role="main" class="flex-grow-1">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Odpoveďe</th>
            </tr>
        </thead>
        <tbody>
    @foreach($answers as $answer)
    <tr> 
        <th> {{$answer->option}} </th>
    </tr>
    @endforeach
    </tbody>
    </table>
    <form method="POST" action="{{ url('/polls/'. $id .'/answer/submit')}}">
    {{ csrf_field() }} 
    <label for="answer">Možnosť odpovede:</label><br>
    <input type="text" id="answer" name="answer"><br>
    <input type="submit">
    </form>
    </main>
    @include('layout.partials.page.footer')
    @include('layout.partials.foot')
</body>
</html> 