@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('title','Login')

@section('main')
<div class="contents">
  <form action="/login" class="login_form" method="post">
    @csrf
    <input type="text" name="email" placeholder="Email" placeholder="{{ old('email') }}">
    <input type="password" name="password" placeholder="Password" value="{{ old('password') }}">
    <button type="submit" class="login_button">ログイン</button>
  </form>
</div>
@endsection