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
    <nav class="navigation">
      <ul class="navigation__list">
        <li class="navigation__list-item"><a href="/" class="navigation__link">Home</a></li>
        <li class="navigation__list-item"><a href="/verify_email" class="navigation__link">Registration</a></li>
        <li class="navigation__list-item"><a href="/login" class="navigation__link">Login</a></li>
      </ul>
    </nav>
    <div class="header__items">
      <div class="header__menu">
        <button class="hamburger-menu" id="js-hamburger-menu">
          <span class="hamburger-menu__bar"></span>
          <span class="hamburger-menu__bar"></span>
          <span class="hamburger-menu__bar"></span>
        </button>
        <h1 class="header__title">Rese</h1>
      </div>
      <div class="header__contents">
        @yield('header__contents')
      </div>
    </div>
  </header>
  @if(session('message'))
    <div class="alert-success">
      {{ session('message') }}
    </div>
  @endif
  @if(session('error_message'))
    <div class="alert-danger">
      {{ session('error_message') }}
    </div>
  @endif
  <main class="main">
    @yield('main')
  </main>
  <script src="https://kit.fontawesome.com/799281266d.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(function () {
      $('#js-hamburger-menu, .navigation__link').on('click', function () {
        $('.navigation').slideToggle(500);
        $('.hamburger-menu').toggleClass('hamburger-menu--open');
      });
    });
  </script>
  @yield('script')
</body>
</html>