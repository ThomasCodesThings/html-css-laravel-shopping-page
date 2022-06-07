<!doctype html>
<html lang="en">
<head>
    <title>I♥home</title>
    @include('layout.partials.head')
</head>

<body class="d-flex flex-column">
    @include('layout.partials.page.header')
  
    <main role="main" class="flex-grow-1">
    <a class="btn btn-warning" href="{{ URL::to('polls/'.  $poll->id .'/answer') }}">Pridať možné odpovede</a>;
    <form method="POST" action="{{ url('polls/'. $poll->id)}}">
    {{ csrf_field() }} 
    <input type="hidden" name="_method" value="PUT">
    <label for="question">Otázka:</label><br>
    <input type="text" id="question" name="question" value="{{ $poll->question }}"><br>
    <label for="date_from">Date from:</label><br>
    <input type="date" id="date_from" name="date_from" value="{{ $poll->date_from }}"><br>
    <label for="date_to">Date to:</label><br>
    <input type="date" id="date_to" name="date_to" value="{{ $poll->date_to }}"><br>
    <button onclick="this.form.submit();">Uložiť</button>
    </form>
    </main>
    @include('layout.partials.page.footer')
    @include('layout.partials.foot')
</body>
</html> 