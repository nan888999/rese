@extends('layouts.before_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('auth.css') }}">
@endsection

@section('main')
<div class="contents">
  会員登録ありがとうございます
  <a class="btn_link" href="/login">ログインする</a>
</div>
@endsection