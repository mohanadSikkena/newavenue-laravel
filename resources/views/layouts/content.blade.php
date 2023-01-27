<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>@yield('page-title') - Solidwears</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  </head>
  <body>
    @include('layouts.navbar')
    <div class="container">
      <div class="row">
        @yield('page-content')
      </div>
    </div>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" charset="utf-8"></script>
  </body>
</html>