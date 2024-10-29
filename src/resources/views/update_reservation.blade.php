@extends('layouts.after_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endsection

@section('main')
<div class="contents">
  <div class="reservation-form__header">
  </div>
    <form action="/update_reservation" class="reservation-form" method="post">
    @csrf
    <h1>予約変更</h1>
    <h2>{{ $reservation->shop->name ?? '' }}</h2>
      <input type="hidden" name="reservation_id" value="{{ $reservation->id ?? '' }}">
      <input type="hidden" name="shop_id" value="{{ $reservation->shop_id ?? '' }}">
      <input class="date-form" type="date" name="date" min="{{ $tomorrow }}" value="{{ old('date', $reservation['date'] ?? '') }}" placeholder="{{ $reservation->date ?? '' }}">
      <div class="form__error">
        @error('date')
        ※ {{ $message }}
        @enderror
      </div>
      <input class="time-form" type="time" name="time" value="{{ old('time', $reservation_time ?? '') }}" placeholder="$reservation->time">
      <div class="form__error">
        @error('time')
        ※ {{ $message }}
        @enderror
      </div>
      <select name="number" class="number-form">
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
      <div class="btn-space">
        <button class="reservation-btn" type="submit">予約を変更する</button>
      </div>
    </form>
  </div>
</div>
@endsection
