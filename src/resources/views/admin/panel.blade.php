@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('header')
<div class="header_title">管理者用Rese</div>
@endsection

@section('main')
<div class="title">店舗代表者登録フォーム</div>
<form action="/admin/register" class="register-form" method="post">
  @csrf
  <div class="register-form__username">
    <i class="fa-solid fa-user" style="color: #44526a;"></i>
    <input type="text" name="name" placeholder="Username" value="{{ old('name') }}">
  </div>
  <div class="form__error">
    @error('name')
      {{ $message }}
    @enderror
  </div>
  <div class="register-form__email">
    <i class="fa-solid fa-envelope gray-icon"></i>
    <input type="text" name="email" placeholder="Email" placeholder="{{ old('email') }}">
  </div>
  <div class="form__error">
    @error('email')
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