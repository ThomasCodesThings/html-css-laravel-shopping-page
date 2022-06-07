<!doctype html>
<html lang="en">
<head>
    <title>I♥home</title>
    @include('layout.partials.head')
</head>

<body class="d-flex flex-column">
    @include('layout.partials.page.header')
  
    <main role="main" class="flex-grow-1">
    <form method="POST" action="{{ url('/polls')}}">
    {{ csrf_field() }} 
    <label for="question">Otázka:</label><br>
    <input type="text" id="question" name="question"><br>
    <label for="date_from">Date from:</label><br>
    <input type="date" id="date_from" name="date_from"><br>
    <label for="date_to">Date to:</label><br>
    <input type="date" id="date_to" name="date_to"><br>
    <input type="submit">
    </form>
    </main>
    @include('layout.partials.page.footer')
    @include('layout.partials.foot')
</body>
</html> 