<!doctype html>
<html lang="en">
<head>
    <title>I♥home</title>
    @include('layout.partials.head')
</head>

<body>
@include('layout.partials.admin.header')
  
<main role="main" class="container">
  
  <div class="admin-template">
      <div class="row">
          <div class="col-sm-12">
              @yield('content')
          </div>
      </div>
  </div>

</main>
  
    @include('layout.partials.foot')
</body>
</html> 