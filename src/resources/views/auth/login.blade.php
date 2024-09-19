@extends('layouts.before_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('main')
<form action="/login" class="login_form" method="post">
  @csrf
  <input type="text" name="email" placeholder="Email" placeholder="{{ old('email') }}">
  <input type="password" name="password" placeholder="Password" value="{{ old('password') }}">
  <button type="submit" class="common-btn">ログイン</button>
</form>
@endsection