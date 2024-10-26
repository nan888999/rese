@extends('layouts.after_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endsection

@section('header')
<div class="header_title">Rese</div>
@endsection

@section('main')
<div class="done">
  <div class="done__text">
    ご予約ありがとうございます
  </div>
  <a href="/" class="common-btn">戻る</a>
</div>
@endsection