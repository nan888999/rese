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
<div class="contents">
  <form action="/admin/mail" class="mail-form" method="post">
    @csrf
    <div class="mail-form__title">メール一斉送信フォーム</div>

    <label class="mail-form__label" for="subject">件名</label>
    <input id="subject"  class="mail-form__input" type="text" name="subject" value="{{ old('subject') }}">
    <div class="form__error">
      @error('subject')
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
    <div class="center">
      <button type="submit" class="common-btn">送信</button>
    </div>
  </form>
</div>
@endsection