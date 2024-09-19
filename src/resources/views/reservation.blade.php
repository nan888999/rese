@extends('layouts.after_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endsection

@section('main')
<div class="contents">
  <div class="shop_details">
    <h1 class="title">Rese</h1>
    <div class="shop_name">
      <a class="return_btn" href="/"><</a>
      <h2>{{ $shop['name'] }}</h2>
    </div>
    <div class="shop_img">
      <img src="{{ $shop['img_url'] }}" alt="{{ $shop['name'] }}">
    </div>
    <div class="shop_tags">
      #{{ $shop->area->name }}
      #{{ $shop->category->name }}
    </div>
    <div class="shop_detail">
      {{ $shop['detail'] }}
    </div>
  </div>

  <div class="reservation_form">
    <h2>予約</h2>
    <form action="/reservation" method="post">
      @csrf
      <input type="hidden" name="shop_id" value="{{ $shop->id }}">
      <input class="date_form" type="date" name="date" value="{{ old('date') }}">
      <input class="time_form" type="time" name="time" value="{{ old('time') }}">
      <select name="number" class="number_form" value="{{ old('number') }}">
        <option value="1">1人</option>
        <option value="2">2人</option>
        <option value="3">3人</option>
        <option value="4">4人</option>
        <option value="5">5人</option>
        <option value="6">6人</option>
        <option value="7">7人</option>
        <option value="8">8人</option>
        <option value="9">9人</option>
        <option value="10">10人</option>
      </select>
      <div class="confirm">
        <table class="confirm__table">
          <tr class="confirm__table--row">
            <th class="confirm__table--header">Shop</th>
            <td>{{ $shop['name'] }}</td>
          </tr>
          <tr class="confirm__table--row">
            <th class="confirm__table--header">Date</th>
            <td>{{ $date ?? '' }}</td>
          </tr>
          <tr class="confirm__table--row">
            <th class="confirm__table--header">Time</th>
            <td>{{ $time ?? '' }}</td>
          </tr>
          <tr class="confirm__table--row">
            <th class="confirm__table--header">Number</th>
            <td>{{ $number ?? '' }}</td>
          </tr>
        </table>
      </div>
      <button class="reservation_btn" type="submit">予約する</button>
    </form>
  </div>
</div>
@endsection