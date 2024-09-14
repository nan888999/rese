<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>飲食店予約サービス Rese</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>
<body>
  <header class="header">
    <div class="header__inner">
      <div class="header__title">Rese</div>
      @yield('header')
    </div>
  </header>
  @if(session('message'))
    <div class="alert">
      {{ session('message') }}
    </div>
    <div class="alert-danger">
      {{ session('message') }}
    </div>
  @endif
  @if('session')
    <div class="alert-danger">
      {{ session('error_message') }}
    </div>
  @endif
  <main class="main">
    <div class="title">
      @yield('title')
    </div>
    @yield('main')
  </main>
</body>
</html>