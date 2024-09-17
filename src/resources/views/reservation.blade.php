@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('reservation.css') }}">
@endsection

@section('main')
<div class="contents">
  <div class="shop_information">
    <div class="shop_name">
      <a href="/"><</a>
      <h2>{{ $shop['name'] }}</h2>
    </div>
    <div class="tags">
      #{{ $area['name'] }}
      #{{ $shop->category }}
    </div>
    <div class="shop_detail">
      {{ $shop['detail'] }}
    </div>
  </div>

  <div class="reservation_form">
    <h2>予約</h2>
    <form action="/reservation" method="post">
      @csrf
      <input type="date" name="date" placeholder="$today" value="{{ old('time') }}">
      <input type="time" name="time" placeholder="$afterOneHour" value="{{ old('time') }}">
      <select name="number" value="{{ old('number') }}"></select>
      <button class="reservation_btn" type="submit">予約する</button>
    </form>
  </div>
</div>