<!doctype html>
<html lang="en">
<head>
    <title>I♥home</title>
    @include('layout.partials.head')
</head>

<body class="d-flex flex-column">
    @include('layout.partials.page.header')
  
    <main role="main" class="flex-grow-1">
<h1>Zoznam ankiet</h1>
    <a class="btn btn-warning" href="{{ URL::to('polls/create') }}">Pridať anketu</a>;
    <table class="table"> <!-- tabulka zdroj z cvicenia 6-->
        <thead class="thead-light">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Otázka</th>
                <th scope="col">Dátum trvania od</th>
                <th scope="col">Dátum trvania do</th>
            </tr>
        </thead>
        <tbody>
        @foreach($polls as $poll)
            <tr>
                <th scope="row">{{$poll->id}}</th>
                <td>{{$poll->question}}</td>
                <td>{{$poll->date_from}}</td>
                <td>{{$poll->date_to}}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a class="btn btn-warning" href="{{ URL::to('polls/' . $poll->id . '/edit') }}">
                            Editovať
                        </a>&nbsp;&nbsp;
                        <form action="{{url('polls', [$poll->id])}}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-danger" value="Vymazať"/>
                        </form>
                            <a class="btn btn-warning" href="{{ URL::to('polls/' . $poll->id) }}">
                            Výsledky
                        </a>&nbsp;&nbsp;
    
                    </div>
                </td>

                
            </tr>
        @endforeach
        </tbody>
    </table>
    </main>
    @include('layout.partials.page.footer')
    @include('layout.partials.foot')
</body>
</html> 