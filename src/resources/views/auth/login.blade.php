@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('header')
<div class="header_title">Rese</div>
@endsection

@section('title','Login')

@section('main')
<div class="contents">
  <form action="/login" class="login_form" method="post">
    @csrf
    <input type="text" name="email" placeholder="Email" placeholder="{{ old('email') }}">
    <input type="password" name="password" placeholder="Password" value="{{ old('password') }}">
    <button type="submit" class="common_btn">ログイン</button>
  </form>
</div>
@endsection