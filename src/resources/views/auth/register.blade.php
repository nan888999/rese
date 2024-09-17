@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('title','Registration')

@section('main')
<div class="content">
  <form action="/register" class="register_form" method="post">
    @csrf
    <input type="text" name="name" placeholder="Username" value="{{ old('name') }}">
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
    <input type="password" name="password" placeholder="Password" value="{{ old('password') }}">
    <input type="password" name="confirmation_password" placeholder="Confirmation Password" value="{{ old('confirmation_password') }}">
    <button type="submit" class="register_button">登録</button>
  </form>
</div>
@endsection