@extends('layouts.before_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('main')
<div class="title">メールアドレス認証</div>
  <form class="verify-form" action="/verify_email" method="post">
    @csrf
    <p>メールアドレスの認証を行います。<br>
    メールアドレスを入力し、「メール送信」ボタンを押してください。</p>
    <div class="form__error">
      @error('email')
      ！{{ $message }}
      @enderror
    </div>
    <div class="login-form__email">
      <i class="fa-solid fa-envelope gray-icon"></i>
      <input type="text" name="email" placeholder="Email" placeholder="{{ old('email') }}">
    </div>
    <button class=" common-btn auth-btn" type="submit">メール送信</button>
  </form>
@endsection