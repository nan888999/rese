@extends('layouts.before_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('main')
<div class="title">Login</div>
<form action="{{ route('login') }}" class="login-form" method="post">
  @csrf
  <div class="login-form__email">
    <i class="fa-solid fa-envelope" style="color: #44526a;"></i>
    <input type="text" name="email" placeholder="Email" placeholder="{{ old('email') }}">
  </div>
  <div class="login-form__password">
    <i class="fa-solid fa-lock" style="color: #44526a;"></i>
    <input type="password" name="password" placeholder="Password" value="{{ old('password') }}">
  </div>
  <button type="submit" class="common-btn auth-btn">ログイン</button>
</form>
@endsection