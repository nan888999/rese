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
      <h2>{{ $shop->name ?? '' }}</h2>
    </div>
    <div class="shop_img">
      <img src="{{ $shop['img_url'] ?? '' }}" alt="{{ $shop['name'] ?? '' }}">
    </div>
    <div class="shop_tags">
      #{{ $shop->area->name ?? '' }}
      #{{ $shop->category->name ?? '' }}
    </div>
    <div class="shop_detail">
      {{ $shop['detail'] ?? ''}}
    </div>
  </div>

  <div class="reservation_form">
    <h2>予約</h2>
    <form action="/reservation_confirm" method="post">
      @csrf
      <input type="hidden" name="shop_id" value="{{ $shop->id ?? '' }}">
      <input class="date_form" type="date" name="date" min="{{ $today }}" value="{{ old('date', $reservation['date'] ?? '') }}" onchange="submit(this.form)">
      <div class="form__error">
        @error('date')
        ※ {{ $message }}
        @enderror
      </div>
      <input class="time_form" type="time" name="time" value="{{ old('time', $reservation['time'] ?? '') }}" onchange="submit(this.form)">
      <div class="form__error">
        @error('time')
        ※ {{ $message }}
        @enderror
      </div>
      <select name="number" class="number_form" onchange="submit(this.form)">
        <option value="" disabled class="option__title" selected>人数を選択してください</option>
        @foreach($number_options as $number_option)
          <option value="{{ $number_option }}"
            @if (!empty($reservation['number']) && $reservation['number'] == $number_option )
              selected
            @endif
          >
          {{ $number_option }}人
          </option>
        @endforeach
      </select>
      <div class="form__error">
        @error('number')
        ※ {{ $message }}
        @enderror
      </div>
      <div class="confirm">
        <table class="confirm__table">
          <tr class="confirm__table--row">
            <th class="confirm__table--header">Shop</th>
            <td>{{ $shop['name'] ?? '' }}</td>
          </tr>
          <tr class="confirm__table--row">
            <th class="confirm__table--header">Date</th>
            <td class="date-area"></td>
          </tr>
          <tr class="confirm__table--row">
            <th class="confirm__table--header">Time</th>
            <td class="time-area"></td>
          </tr>
          <tr class="confirm__table--row">
            <th class="confirm__table--header">Number</th>
            <td class="number-area"></td>
          </tr>
        </table>
      </div>
    </form>
    <form action="/reservation" method="post">
      @csrf
      <input type="hidden" name="shop_id" value="{{ $shop->id ?? '' }}">
      <input type="hidden" name="date" value="{{ old('date', $reservation['date'] ?? '' ) }}">
      <input type="hidden" name="time" value="{{ old('time', $reservation['time'] ?? '' ) }}">
      <input type="hidden" name="number" value="{{ old('number', $reservation['number'] ?? '' ) }}">
      <button class="reservation_btn" type="submit">予約する</button>
    </form>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
$(function(){
  $("#submit_select").change(function(){
    $("#submit_form").submit();
  });

  var date = $('.date_form').val();
  $('.date-area').html(date);

  var time = $('.time_form').val();
  $('.time-area').html(time);

  var number = $('.number_form').val();
  if (!number) {
    $('.number-area').html('');
  } else {
    $('.number-area').html(number + "人");
  }
});
</script>
@endsection