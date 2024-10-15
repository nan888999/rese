@extends('layouts.before_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('header')
<div class="header_title">Rese</div>
@endsection

@section('title','Registration')

@section('main')
<div class="title">Registration</div>
<form action="/register" class="register-form" method="post">
  @csrf
  <div class="register-form__username">
    <i class="fa-solid fa-user" style="color: #44526a;"></i>
    <input type="text" name="name" placeholder="Username" value="{{ old('name') }}">
  </div>
  <div class="register-form__email">
    <i class="fa-solid fa-envelope" style="color: #44526a;"></i>
    <input type="text" name="email" placeholder="Email" placeholder="{{ old('email') }}">
  </div>
  <div class="register-form__password">
    <i class="fa-solid fa-lock" style="color: #44526a;"></i>
    <input type="password" name="password" placeholder="Password" value="{{ old('password') }}">
  </div>
  <div class="register-form__password">
    <i class="fa-solid fa-lock" style="color: #44526a;"></i>
    <input type="password" name="confirmation_password" placeholder="Confirmation Password" value="{{ old('confirmation_password') }}">
  </div>
  <button type="submit" class="common-btn">登録</button>
</form>
@endsection