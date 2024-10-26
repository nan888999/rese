@extends('layouts.before_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('header')
<div class="header_title">Rese</div>
@endsection

@section('main')
<div class="title">Registration</div>
<form action="/register" class="register-form" method="post">
  @csrf
  <input type="hidden" name="user_id" value="{{ $user_id }}">
  <div class="register-form__username">
    <i class="fa-solid fa-user gray-icon"></i>
    <input type="text" name="name" placeholder="Username" value="{{ old('name') }}">
  </div>
  <div class="form__error">
    @error('name')
      {{ $message }}
    @enderror
  </div>
  <div class="register-form__password">
    <i class="fa-solid fa-lock gray-icon"></i>
    <input type="password" name="password" placeholder="Password" value="{{ old('password') }}">
  </div>
    <div class="form__error">
    @error('password')
      {{ $message }}
    @enderror
  </div>
  <div class="register-form__password">
    <i class="fa-solid fa-lock gray-icon"></i>
    <input type="password" name="password_confirmation" placeholder="Password Confirmation" value="{{ old('password_confirmation') }}">
  </div>
  <button type="submit" class="common-btn auth-btn">登録</button>
</form>
@endsection