@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/panel.css') }}">
@endsection

@section('header__contents')
<div class="menu-buttons">
  <button onclick="location.href='/admin/panel'" class="common-btn">店舗代表者登録</button>
  <button onclick="location.href='/admin/mail'" class="common-btn">メール</button>
</div>
@endsection

@section('main')
<div class="title">メール一斉送信フォーム</div>
<form action="/admin/mail" class="mail-form" method="post">
  @csrf
  <label class="mail-form__label" for="subtitle">件名</label>
  <input id="subtitle"  class="mail-form__input" type="text" name="subtitle" value="{{ old('subtitle') }}">
  <div class="form__error">
    @error('subtitle')
      {{ $message }}
    @enderror
  </div>

  <label class="mail-form__label" for="body">本文</label>
  <textarea id="body"  class="mail-form__textarea" name="body">{{ old('body') }}</textarea>
  <div class="form__error">
    @error('body')
      {{ $message }}
    @enderror
  </div>

  <button type="submit" class="common-btn auth-btn">送信</button>
</form>
@endsection