@extends('layouts.before_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('main')
<div class="thanks-message">
  <p>会員登録ありがとうございます</p>
  <a href="/login" class="common-btn link-btn">ログインする</a>
</div>
@endsection